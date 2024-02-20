<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegReestrKP;
use Carbon\Carbon;
use App\Models\AdditionalFile;
use App\Models\Projects;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegReestrKPController extends Controller
{
    // public function index()
    // {
    //     $RegReestrKP = RegReestrKP::all();
    //     $additionalFiles = AdditionalFile::all(); // Получаем все дополнительные файлы

    //     return view('commercial-offers', compact('RegReestrKP', 'additionalFiles'));
    // }
    public function index()
    {
        $RegReestrKP = RegReestrKP::all();

        // Получаем все дополнительные файлы для каждого объекта RegReestrKP
        $RegReestrKP->each(function ($regReestrKP) {
            $regReestrKP->additionalFiles = $regReestrKP->additionalFiles()->get();
        });

        return view('commercial-offers', compact('RegReestrKP'));
    }

    public function showForm()
    {
        $year = date('y');
        $lastKP = RegReestrKP::whereYear('created_at', date('Y'))->max('numIncoming');
        $lastKP = $lastKP ? explode('-', $lastKP)[1] : 0;
        $numIncoming = 'КП-' . ($lastKP + 1) . '/' . $year;

        return view('project-map', compact('numIncoming'));
    }

    // ----------------------- ДОБАВЛЕНИЕ КП --------------------------------------------
    public function store(Request $request)
    {
        $data = $request->input('offer')[0];

        // Генерация номера numIncoming
        $year = date('y');
        $lastKP = RegReestrKP::whereYear('created_at', date('Y'))->max('numIncoming');

        // Извлекаем числовое значение из строки
        preg_match('/\d+/', $lastKP, $matches);
        $lastKP = isset($matches[0]) ? $matches[0] : 0;

        // Проверка $lastKP на null
        if ($lastKP === null) {
            $lastKP = 0; // Установка значения по умолчанию
        }

        $numIncoming = 'КП-' . ($lastKP + 1) . '/' . $year;

        $data['numIncoming'] = $numIncoming;
        $data['date'] = Carbon::parse($data['date']);
        $reestrKP = RegReestrKP::create($data);

        // Связываем КП с проектом
        $projectNum = $request->input('project_num'); // Получаем номер проекта из формы
        $project = Projects::where('projNum', $projectNum)->first(); // Находим проект по номеру
        if ($project) {
            $reestrKP->project_num = $projectNum; // Связываем КП с проектом
            $reestrKP->save(); // Сохраняем изменения
        }

        // Обработка загрузки файла Word, если он предусмотрен
        if ($request->hasFile('word_file')) {
            $wordFile = $request->file('word_file');
            $originalWordFileName = $wordFile->getClientOriginalName(); // Получаем исходное имя файла
            $fileName = $reestrKP->id . '_' . time() . '.' . $wordFile->getClientOriginalExtension();
            $wordFile->storeAs('word_files', $originalWordFileName);
            $reestrKP->word_file = $originalWordFileName; // Присвоение имени файла атрибуту модели
            $reestrKP->original_file_name = $originalWordFileName; // Сохраняем оригинальное имя файла
            $reestrKP->save(); // Сохранение изменений
        }

        // Обработка загрузки дополнительных файлов
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $file) {
                $originalFileName = $file->getClientOriginalName(); // Получаем исходное имя файла
                $fileName = $reestrKP->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $fileContent = file_get_contents($file->getRealPath()); // Получаем содержимое файла
                // Сохранение файла в таблице для дополнительных файлов
                AdditionalFile::create([
                    'kp_id' => $reestrKP->id,
                    'original_file_name' => $originalFileName, // Сохраняем оригинальное имя файла
                    'file_name' => $fileName,
                    'file_content' => $fileContent,
                ]);
                // Сохранение файла на сервере
                $file->storeAs('additional_files', $originalFileName); // Используем оригинальное имя файла для сохранения
            }
        }
        return redirect()->back()->with('success', 'КП успешно создано.');
    }

    // --------------------------------- СКАЧИВАНИЕ КП ----------------------------------
    public function download($id)
    {
        $reestrKP = RegReestrKP::findOrFail($id);
        $filePath = storage_path('app/word_files/' . $reestrKP->word_file);
        return response()->download($filePath);
    }

    public function downloadkpAdditional($id)
    {
        $additionalFile = AdditionalFile::findOrFail($id);
        $filePath = storage_path('app/additional_files/' . $additionalFile->original_file_name); // Используем оригинальное имя файла
        return response()->download($filePath, $additionalFile->original_file_name); // Указываем оригинальное имя файла для скачивания
    }



    public function getKPDetails($id)
    {
        $reestrKP = RegReestrKP::findOrFail($id);

        // Получаем информацию о файле word_file, если он есть
        $wordFile = null;
        if ($reestrKP->word_file) {
            $wordFile = [
                'name' => $reestrKP->original_file_name,
                'url' => route('download-kp', ['id' => $reestrKP->id]),
            ];
        }

        // Получаем все дополнительные файлы для данного КП
        $additionalFiles = $reestrKP->additionalFiles->map(function ($file) {
            return [
                'id' => $file->id,
                'name' => $file->original_file_name,
                'url' => route('download-kpAdditional', ['id' => $file->id]),
            ];
        });

        // Подготавливаем данные для ответа
        $data = [
            'numIncoming' => $reestrKP->numIncoming,
            'orgName' => $reestrKP->orgName,
            'whom' => $reestrKP->whom,
            'sender' => $reestrKP->sender,
            'amountNDS' => $reestrKP->amountNDS,
            'purchNum' => $reestrKP->purchNum,
            'date' => $reestrKP->date,
            'wordFile' => $wordFile, // Информация о файле word_file
            'additionalFiles' => $additionalFiles,
        ];

        // Возвращаем данные в формате JSON
        return response()->json($data);
    }



    public function updateAdditionalFile(Request $request, $id)
    {
        // Находим запись дополнительного файла по ID
        $additionalFile = AdditionalFile::findOrFail($id);

        // Обновляем файл, если он был загружен
        if ($request->hasFile('additional_file')) {
            $file = $request->file('additional_file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('additional_files', $fileName); // Предполагается, что дополнительные файлы сохраняются в папку additional_files

            // Обновляем имя файла и содержимое
            $additionalFile->file_name = $fileName;
            $additionalFile->original_file_name = $fileName;
            $additionalFile->file_content = file_get_contents($file->getRealPath()); // Предполагается, что содержимое файла сохраняется в базе данных
            $additionalFile->save();

            return response()->json(['name' => $fileName]);
        }

        // Редирект или возврат ответа в зависимости от вашей логики
        return response()->json(['success' => true]);
    }

    // --------------------- РЕДАКТИРОВАНИЕ КП -------------------------------
    public function update(Request $request, $id)
    {
        // Находим запись по ID
        $reestrKP = RegReestrKP::findOrFail($id);

        // Обновляем данные из формы
        $reestrKP->orgName = $request->orgName;
        $reestrKP->whom = $request->whom;
        $reestrKP->sender = $request->sender;
        $reestrKP->amountNDS = $request->amountNDS;
        $reestrKP->purchNum = $request->purchNum;
        $reestrKP->date = $request->date;

        // Обработка замены файла word
        if ($request->hasFile('word_file')) {
            $wordFile = $request->file('word_file');
            $fileName = $wordFile->getClientOriginalName();
            $wordFile->storeAs('word_files', $fileName);

            $reestrKP->word_file = $fileName;
            $reestrKP->original_file_name = $fileName;
        }

        // Обработка загрузки дополнительных файлов
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $file) {
                $originalFileName = $file->getClientOriginalName(); // Получаем исходное имя файла
                $fileName = $reestrKP->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $fileContent = file_get_contents($file->getRealPath()); // Получаем содержимое файла
                // Сохранение файла в таблице для дополнительных файлов
                AdditionalFile::create([
                    'kp_id' => $reestrKP->id,
                    'original_file_name' => $originalFileName, // Сохраняем оригинальное имя файла
                    'file_name' => $fileName,
                    'file_content' => $fileContent,
                ]);
                // Сохранение файла на сервере
                $file->storeAs('additional_files', $originalFileName); // Используем оригинальное имя файла для сохранения
            }
        }

        // Сохраняем изменения
        $reestrKP->save();

        // Обработка замены дополнительных файлов
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'additionalFile_') !== false) {
                $fileId = substr($key, strrpos($key, '_') + 1);
                $file = $request->file($key);
                if ($file) {
                    // Находим существующую запись дополнительного файла по ID
                    $additionalFile = AdditionalFile::findOrFail($fileId);

                    // Если файл был изменен, обновляем его
                    if ($file->isValid()) {
                        $fileName = $file->getClientOriginalName();
                        $file->storeAs('additional_files', $fileName);
                        $additionalFile->file_name = $fileName;
                        $additionalFile->original_file_name = $fileName;
                        $additionalFile->file_content = file_get_contents($file->getRealPath());
                        $additionalFile->save();
                    }
                }
            }
        }
        // return response()->json(['success' => true]);
        return redirect()->route('rco');
    }

    public function deleteAdditionalFile($id)
    {
        // Находим запись дополнительного файла по ID
        $additionalFile = AdditionalFile::findOrFail($id);

        // Удаление файла из базы данных
        $additionalFile->delete();

        return response()->json(['success' => true]);
    }
    // public function deleteWordFile($id)
    // {
    //     $reestrKP = RegReestrKP::findOrFail($id);

    //     // Удаление файла из хранилища
    //     // Storage::delete('word_files/' . $reestrKP->word_file);

    //     // Удаление информации о файле из базы данных
    //     $reestrKP->word_file = null;
    //     $reestrKP->original_file_name = null;
    //     $reestrKP->save();

    //     return response()->json(['message' => 'Файл удален успешно']);
    // }

    public function deleteKP($id)
    {
        $reestrKP = RegReestrKP::findOrFail($id);

        // Удаление связанных дополнительных файлов
        $reestrKP->additionalFiles()->delete();

        // Удаление самого КП
        $reestrKP->delete();

        return response()->json(['success' => true]);
    }
}
