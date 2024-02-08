<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegReestrKP;
use Carbon\Carbon;
use App\Models\AdditionalFile;
use Illuminate\Support\Facades\Storage;

class RegReestrKPController extends Controller
{
    public function index()
    {
        $RegReestrKP = RegReestrKP::all();
        $additionalFiles = AdditionalFile::all(); // Получаем все дополнительные файлы

        return view('commercial-offers', compact('RegReestrKP', 'additionalFiles'));
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
        $reestrKP = RegReestrKP::findOrFail($id); // Находим запись по ID
    
        // Получаем информацию о файле word_file, если он есть
        $wordFile = null;
        if ($reestrKP->word_file) {
            $wordFile = [
                'name' => $reestrKP->original_file_name, // Имя файла
                'url' => route('download-kp', ['id' => $reestrKP->id]), // URL для скачивания файла
            ];
        }
    
        // Получаем дополнительные файлы, принадлежащие выбранной записи
        $additionalFiles = [];
        $additionalFilesRecords = AdditionalFile::where('kp_id', $id)->get();
        foreach ($additionalFilesRecords as $file) {
            $additionalFiles[] = [
                'id' => $file->id, // Идентификатор файла
                'name' => $file->original_file_name, // Имя файла
                'url' => route('download-kpAdditional', ['id' => $file->id]), // URL для скачивания файла
            ];
        }
    
        // Подготавливаем данные для ответа
        $data = [
            'orgName' => $reestrKP->orgName,
            'whom' => $reestrKP->whom,
            'sender' => $reestrKP->sender,
            'amountNDS' => $reestrKP->amountNDS,
            'purchNum' => $reestrKP->purchNum,
            'date' => $reestrKP->date,
            'wordFile' => $wordFile, // Информация о файле word_file
            'additionalFiles' => $additionalFiles, // Информация о дополнительных файлах
        ];
    
        // Возвращаем данные в формате JSON
        return response()->json($data);
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

        // Замена существующего файла Word
        if ($request->hasFile('word_file')) {
            // Получаем новый файл и сохраняем его
            $wordFile = $request->file('word_file');
            $fileName = $wordFile->getClientOriginalName();
            $wordFile->storeAs('word_files', $fileName); // Предполагается, что файлы будут сохранены в директории storage/app/word_files

            // Обновляем информацию о файле в базе данных
            $reestrKP->word_file = $fileName;
            $reestrKP->original_file_name = $fileName; // Предполагаем, что имя файла сохраняется в базу данных
        }

        // Удаление существующего файла Word
        if ($request->has('delete_word_file') && $request->delete_word_file) {
            // Удаляем файл и обнуляем соответствующие поля в базе данных
            Storage::delete('word_files/' . $reestrKP->word_file);
            $reestrKP->word_file = null;
            $reestrKP->original_file_name = null;
        }

        // Добавление новых дополнительных файлов
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $file) {
                // Сохраняем каждый файл
                $fileName = $file->getClientOriginalName();
                $file->storeAs('additional_files', $fileName); // Предполагается, что файлы будут сохранены в директории storage/app/additional_files

                // Создаем новую запись в таблице additional_files
                $additionalFile = new AdditionalFile();
                $additionalFile->reg_reestr_kp_id = $reestrKP->id;
                $additionalFile->original_file_name = $fileName;
                $additionalFile->file_path = $fileName; // Предполагаем, что путь к файлу сохраняется в базу данных
                $additionalFile->save();
            }
        }


        // Обновление каждого дополнительного файла
        if ($request->hasFile('additional_files')) {
            foreach ($request->file('additional_files') as $file) {
                // Сохраняем каждый файл
                $fileName = $file->getClientOriginalName();
                $file->storeAs('additional_files', $fileName); // Предполагается, что файлы будут сохранены в директории storage/app/additional_files

                // Обновляем информацию о файле в базе данных
                $additionalFileId = $request->replace_additional_file_id;
                $additionalFile = AdditionalFile::findOrFail($additionalFileId);
                $additionalFile->original_file_name = $fileName;
                $additionalFile->file_path = $fileName; // Предполагаем, что путь к файлу сохраняется в базу данных
                $additionalFile->save();
            }
        }

        // Удаление каждого дополнительного файла
        if ($request->has('delete_additional_file_id')) {
            $additionalFileId = $request->delete_additional_file_id;
            $additionalFile = AdditionalFile::findOrFail($additionalFileId);
            Storage::delete('additional_files/' . $additionalFile->file_path);
            $additionalFile->delete();
        }

        // Удаление всего коммерческого предложения
        if ($request->has('delete_offer') && $request->delete_offer) {
            // Удаляем все файлы и записи связанные с данной записью коммерческого предложения
            Storage::delete('word_files/' . $reestrKP->word_file);
            foreach ($reestrKP->additionalFiles as $file) {
                Storage::delete('additional_files/' . $file->file_path);
                $file->delete();
            }
            $reestrKP->delete();
        }

        // Сохраняем изменения
        $reestrKP->save();

        // Редирект или возврат ответа в зависимости от вашей логики
        return response()->json(['success' => true]);
    }
}
