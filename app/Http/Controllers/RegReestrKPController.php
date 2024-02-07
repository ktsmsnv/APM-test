<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegReestrKP;
use Carbon\Carbon;
use App\Models\AdditionalFile;

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
}
