<?php

namespace App\Http\Controllers;

//use Yajra\DataTables\Facades\DataTables;
use App\Models\AdditionalFile;
use App\Models\basePossibilities;
use App\Models\baseRisks;
use App\Models\RegReestrKP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ContractStorage;
use App\Models\AdditionalFileCS;

use Illuminate\Support\Facades\DB;

class ContractStorageController extends Controller
{
    public function getContractStorage($id)
    {
        $contractStorage = ContractStorage::find($id);
        return response()->json($contractStorage);
    }

    public function index()
    {
        $contractStorage = ContractStorage::all();
        $contractStorage->each(function ($contractStorage) {
            $contractStorage->additionalFilesCS = $contractStorage->additionalFilesCS()->get();
        });

        return view('contract-storage', compact('contractStorage'));
    }

    // сохранение полей в бд
    public function contractStorageStore(Request $request)
    {
        try {
            // Проверка валидации данных
            $validatedData = $request->validate([
                'contractName' => 'required',
                'contractor' => 'required',
                'dateStart' => 'required|date',
                'dateEnd' => 'required|date',
                'daysLeft' => 'required|integer',
            ]);

            // Создание записи в таблице ContractStorage
            $contractStorage = ContractStorage::create($validatedData);

            // Обработка загрузки дополнительных файлов
            if ($request->hasFile('additionalContracts')) {
                foreach ($request->file('additionalContracts') as $file) {
                    // Получение исходного имени файла и генерация уникального имени для сохранения
                    $originalFileName = $file->getClientOriginalName();
                    $fileName = $contractStorage->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                    // Получение содержимого файла
                    $fileContent = file_get_contents($file->getRealPath());

                    // Сохранение файла в таблице AdditionalFileCS
                    AdditionalFileCS::create([
                        'cs_id' => $contractStorage->id,
                        'original_file_name_cs' => $originalFileName,
                        'file_name_cs' => $fileName,
                        'file_content_cs' => $fileContent,
                    ]);
                    // Сохранение файла на сервере
                    $file->storeAs('additional_files_contractStorage', $fileName);
                }
            }
//            dd($request->file('additionalContracts'));
            // Редирект после успешного сохранения
            return redirect()->route('contractStorage');
        } catch (\Exception $e) {
            // Обработка исключения
            dd($e->getMessage());
        }
    }


    public function downloadCSAdditional($id)
    {
        $additionalFileContractStorage = AdditionalFileCS::findOrFail($id);
        $filePath = storage_path('app/additional_files_contractStorage/' . $additionalFileContractStorage->original_file_name_cs); // Используем оригинальное имя файла
        return response()->download($filePath, $additionalFileContractStorage->original_file_name_cs); // Указываем оригинальное имя файла для скачивания
    }

    public function getCSDetails($id)
    {
        $contractStorage = ContractStorage::findOrFail($id);

        // Получаем все дополнительные файлы для данного КП
        $additionalFilesCS = $contractStorage->additionalFilesCS->map(function ($file){
            return [
                'id' => $file->id,
                'name' => $file->original_file_name_cs,
                'url' => route('download-csAdditional', ['id' => $file->id]),
            ];
        });

        // Подготавливаем данные для ответа
        $data = [
            'contractName' => $contractStorage->contractName,
            'contractor' => $contractStorage->contractor,
            'dateStart' => $contractStorage->dateStart,
            'dateEnd' => $contractStorage->dateEnd,
            'daysLeft' => $contractStorage->daysLeft,
            'additionalFilesCS' => $additionalFilesCS,
        ];

        // Возвращаем данные в формате JSON
        return response()->json($data);
    }
    public function updateAdditionalFile(Request $request, $id)
    {
        // Находим запись дополнительного файла по ID
        $additionalFile = AdditionalFileCS::findOrFail($id);

        // Обновляем файл, если он был загружен
        if ($request->hasFile('additionalContracts')) {
            $file = $request->file('additionalContracts');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('additional_files_contractStorage', $fileName); // Предполагается, что дополнительные файлы сохраняются в папку additional_files

            // Обновляем имя файла и содержимое
            $additionalFile->file_name_cs = $fileName;
            $additionalFile->original_file_name_cs = $fileName;
            $additionalFile->file_content_cs = file_get_contents($file->getRealPath()); // Предполагается, что содержимое файла сохраняется в базе данных
            $additionalFile->save();

            return response()->json(['name' => $fileName]);
        }

        // Редирект или возврат ответа в зависимости от вашей логики
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        // Находим запись по ID
        $contractStorage = ContractStorage::findOrFail($id);

        // Обновляем данные из формы
        $contractStorage->contractName = $request->contractName;
        $contractStorage->contractor = $request->contractor;
        $contractStorage->dateStart = $request->dateStart;
        $contractStorage->dateEnd = $request->dateEnd;
        $contractStorage->daysLeft = $request->daysLeft;

        // Обработка загрузки дополнительных файлов
        if ($request->hasFile('additionalContracts')) {
            foreach ($request->file('additionalContracts') as $file) {
                $originalFileName_cs = $file->getClientOriginalName(); // Получаем исходное имя файла
                $fileName_cs = $contractStorage->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $fileContent_cs = file_get_contents($file->getRealPath()); // Получаем содержимое файла
                // Сохранение файла в таблице для дополнительных файлов
                AdditionalFileCS::create([
                    'cs_id' => $contractStorage->id,
                    'original_file_name_cs' => $originalFileName_cs, // Сохраняем оригинальное имя файла
                    'file_name_cs' => $fileName_cs,
                    'file_content_cs' => $fileContent_cs,
                ]);
                // Сохранение файла на сервере
                $file->storeAs('additional_files_contractStorage', $originalFileName_cs); // Используем оригинальное имя файла для сохранения
            }
        }

        // Сохраняем изменения
        $contractStorage->save();

        // Обработка замены дополнительных файлов
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'additionalFileCS_') !== false) {
                $fileId = substr($key, strrpos($key, '_') + 1);
                $file = $request->file($key);
                if ($file) {
                    // Находим существующую запись дополнительного файла по ID
                    $additionalFile = AdditionalFileCS::findOrFail($fileId);

                    // Если файл был изменен, обновляем его
                    if ($file->isValid()) {
                        $fileName = $file->getClientOriginalName();
                        $file->storeAs('additional_files_contractStorage', $fileName);
                        $additionalFile->file_name_cs = $fileName;
                        $additionalFile->original_file_name_cs = $fileName;
                        $additionalFile->file_content_cs = file_get_contents($file->getRealPath());
                        $additionalFile->save();
                    }
                }
            }
        }
        // return response()->json(['success' => true]);
        return redirect()->route('contractStorage');
    }

    public function deleteAdditionalFile($id)
    {
        // Находим запись дополнительного файла по ID
        $additionalFile = AdditionalFileCS::findOrFail($id);

        // Удаление файла из базы данных
        $additionalFile->delete();

        return response()->json(['success' => true]);
    }

    public function deleteCS($id)
    {
        $contractStorage = ContractStorage::findOrFail($id);

        // Удаление связанных дополнительных файлов
        $contractStorage->additionalFilesCS()->delete();

        // Удаление самого КП
        $contractStorage->delete();

        return response()->json(['success' => true]);
    }
}
