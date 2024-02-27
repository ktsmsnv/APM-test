<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Маршрут для главной страницы входа доступен только неаутентифицированным пользователям
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});

// Все маршруты доступны только аутентифицированным пользователям
Route::middleware(['auth'])->group(function () {

    // Главная страница (отображение реестров)
    Route::get('/home', 'App\Http\Controllers\DataController@index')->name('home');

    Route::get('/getData_group_1', 'App\Http\Controllers\DataController@getData_group_1');
    Route::get('/getData_group_2', 'App\Http\Controllers\DataController@getData_group_2');
    Route::get('/getData_group_3', 'App\Http\Controllers\DataController@getData_group_3');
    Route::get('/getData_group_4', 'App\Http\Controllers\DataController@getData_group_4');

    // Все карты проекта
    Route::get('/project-maps/all', 'App\Http\Controllers\ProjectController@allData')->name('project-maps');
    // одна карта проекта
    Route::get('/project-maps/all/{id}/{tab?}', 'App\Http\Controllers\ProjectController@showOneMessage')->name('project-data-one');


    // ТАБЫ на странице КАРТА ПРОЕКТА
    Route::get('/tables/{tab}/{id}', 'App\Http\Controllers\TabController@show')->name('tab.show');



    // обновление (редактирование) карты проекта -> РАСЧЕТ
    Route::get('/project-maps/all/{id}/{tab}/update-calculation', 'App\Http\Controllers\ProjectController@updateCalculation')->name('project-map-update');
    Route::post('/project-maps/all/{id}/calculation-update', 'App\Http\Controllers\ProjectController@updateCalculationSubmit')->name('project-map-update-submit');


    Route::post('/delete-row/{table}/{id}', 'App\Http\Controllers\ProjectController@deleteRow')->name('delete.row');


    // обновление (редактирование) карты проекта -> РЕАЛИЗАЦИЯ
    Route::get('/project-maps/all/{id}/{tab}/update-realization', 'App\Http\Controllers\ProjectController@updateRealization')->name('update-realization');
    Route::post('/project-maps/all/{id}/realization-update', 'App\Http\Controllers\ProjectController@updateRealizationSubmit')->name('realization-update-submit');

    // обновление (редактирование) карты проекта -> ИЗМЕНЕНИЯ
    Route::get('/project-maps/all/{id}/{tab}/update-changes', 'App\Http\Controllers\ProjectController@updateChanges')->name('update-changes');
    Route::post('/project-maps/all/{id}/changes-update', 'App\Http\Controllers\ProjectController@updateChangesSubmit')->name('changes-update-submit');


   
    //удаление карты проекта (НЕАКТУАЛЬНО)
    Route::get('/project-maps/all/{id}/delete', 'App\Http\Controllers\ProjectController@deleteMessage')->name('project-map-delete');
    
    //Добавление дневника проекта
    Route::post('/tables/notes-add/{project}', 'App\Http\Controllers\ProjectController@store')->name('tables.notes-add');
    //Удаление записи из дневника проекта
    Route::delete('/tables/notes-delete/{project}/{note}', 'App\Http\Controllers\ProjectController@destroy')->name('tables.notes-delete');
    // Редактирование записи из дневника проекта
    Route::get('/tables/notes-edit/{project}/{note}', 'App\Http\Controllers\ProjectController@edit')->name('tables.notes-edit');
    Route::put('/tables/notes-update/{project}/{note}', 'App\Http\Controllers\ProjectController@update')->name('tables.notes-update');

    Route::get('/notes-download/{project}/{projNum}', 'App\Http\Controllers\ProjectController@exportNotesWord')->name('notes-word');


    // реестр КП
    Route::get('/register-commercial-offers', 'App\Http\Controllers\RegReestrKPController@index')->name('rco');



    // Марщрут страницы базы рисков
    Route::get('/base-risks', 'App\Http\Controllers\BaseRisksController@index')->name('baseRisks');
    //создание новой записи в базе рисков
    Route::post('/base-risks/baseRisks-store', 'App\Http\Controllers\BaseRisksController@store')->name('baseRisks-store');
    // удаление записи из базы рисков
    Route::get('/base-risks/baseRisks-delete/{id}', 'App\Http\Controllers\BaseRisksController@delete')->name('baseRisks-delete');
    // редактирование записи в базе рисков
    Route::post('/base-risks/baseRisks-update/{id}', 'App\Http\Controllers\BaseRisksController@update')->name('baseRisks-update');

    Route::get('/get-base-risk/{id}', 'App\Http\Controllers\BaseRisksController@getBaseRisk');


    //создание новой записи в базе рисков
    Route::post('/base-risks/basePossibilities-store', 'App\Http\Controllers\BasePossibilitiesController@store')->name('basePossibilities-store');
    // удаление записи из базы рисков
    Route::get('/base-risks/basePossibilities-delete/{id}', 'App\Http\Controllers\BasePossibilitiesController@delete')->name('basePossibilities-delete');
    // редактирование записи в базе рисков
    Route::post('/base-possibilities/basePossibilities-update/{id}', 'App\Http\Controllers\BasePossibilitiesController@update')->name('basePossibilities-update');




    // создание карты проекта -> РАСЧЕТ (ОБЩАЯ ИНФА И КОНТАКТ ЛИСТ)
    Route::get('/project-maps/create', 'App\Http\Controllers\ProjectController@create')->name('project-create');


    // создание карты проекта РАСЧЕТ (ОБЩАЯ ИНФА И КОНТАКТ ЛИСТ) -> сохранение в БД
    Route::post('/project-maps/create/save', 'App\Http\Controllers\ProjectController@storeNew')->name('project-store');


    // ---------------- ДОБАВЛЕНИЕ ОБОРУДОВАНИЯ -----------------
    Route::post('/project-continue/{id}', 'App\Http\Controllers\ProjectController@projectСontinue')->name('project-continue');


    // ---------------- ДОБАВЛЕНИЕ ОБОРУДОВАНИЯ -----------------
    Route::post('/add-equipment/{id}', 'App\Http\Controllers\ProjectController@addEquipment')->name('addEquipment');
    // ---------------- ДОБАВЛЕНИЕ ОБОРУДОВАНИЯ -----------------
    Route::post('/add-expenses/{id}', 'App\Http\Controllers\ProjectController@addExpenses')->name('addExpenses');
    // ---------------- ДОБАВЛЕНИЕ ИТОГО -----------------
    Route::post('/add-totals/{id}', 'App\Http\Controllers\ProjectController@addTotals')->name('addTotals');
    // ---------------- ДОБАВЛЕНИЕ УРОВЕНЯ НАЦЕНКИ -----------------
    Route::post('/add-markups/{id}', 'App\Http\Controllers\ProjectController@addMarkups')->name('addMarkups');
    // ---------------- ДОБАВЛЕНИЕ УРОВЕНЯ НАЦЕНКИ -----------------
    Route::post('/add-risks/{id}', 'App\Http\Controllers\ProjectController@addRisks')->name('addRisks');


    // АВТОСОХРАНЕНИЕ КАРТЫ ПРОЕКТА
    Route::post('/autosave-project-data', 'App\Http\Controllers\ProjectController@autoSave')->name('autosave-project-data');



    Route::delete('/delete_additional_expense/{id}', 'App\Http\Controllers\ProjectController@deleteRow')->name('delete.additional.expense');

    // создание карты проекта -> РЕАЛИЗАЦИЯ
    Route::get('/project-maps/create/realization-{id}/create', 'App\Http\Controllers\realizationController@create')->name('realization-create');
    // создание карты проекта -> РЕАЛИЗАЦИЯ -> сохранение в БД
    Route::post('/project-maps/create/realization-{id}/save', 'App\Http\Controllers\realizationController@storeNew')->name('realization-store');
    // ссоздание карты проекта -> РЕАЛИЗАЦИЯ -> вывод связанных таблиц
    Route::get('/project-maps/create/realization-{id}', 'App\Http\Controllers\realizationController@showDataCalculation')->name('realization-create');


    // создание карты проекта -> ИЗМЕНЕНИЯ
    Route::get('/project-maps/create/changes-{id}/create', 'App\Http\Controllers\changesController@create')->name('changes-create');
    // создание карты проекта ИЗМЕНЕНИЯ -> сохранение в БД
    Route::post('/project-maps/create/changes-{id}/save', 'App\Http\Controllers\changesController@storeNew')->name('changes-store');
    // обновление (редактирование) карты проекта ИЗМЕНЕНИЯ 
    Route::put('/project-maps/changes-update/{id}', 'App\Http\Controllers\ChangesController@update')->name('changes-update');
    // ссоздание карты проекта ИЗМЕНЕНИЯ -> вывод связанных таблиц
    Route::get('/project-maps/create/changes-{id}', 'App\Http\Controllers\changesController@showDataCalculation')->name('changes-create');
    // ссоздание карты проекта ИЗМЕНЕНИЯ ->удаление
    Route::get('/project-maps/changes-delete/{id}', 'App\Http\Controllers\changesController@delete')->name('changes-delete');





    Route::get('/project-maps/all/{id}/{tab}/update-smk', 'App\Http\Controllers\ProjectController@updateSMK')->name('update-smk');
    Route::get('/project-maps/create/smk-{id}', 'App\Http\Controllers\SmkController@showDataSMK')->name('smk-create');
    Route::post('/project-maps/create/smk-{id}/save', 'App\Http\Controllers\SmkController@storeNew')->name('smk-store');
    Route::put('/project-maps/smk-update/{id}', 'App\Http\Controllers\SmkController@update')->name('smk-update');



    // создание карты проекта ОТЧЕТ -> сохранение в БД
    Route::post('/project-maps/all/{id}/store-report', 'App\Http\Controllers\reportController@store')->name('report-store');
    // карта проекта ОТЧЕТ -> выгрузка в word
    Route::get('/project-maps/all/{id}/{projNum}/export-word', 'App\Http\Controllers\reportController@exportWord')->name('report-word');
    // обновление (редактирование) карты проекта ОТЧЕТ 
    Route::post('/project-maps/all/{id}/{tab}/update-report', 'App\Http\Controllers\reportController@updateMessageSubmit')->name('report-update-submit');
    //удаление карты проекта ОТЧЕТ пуе
    Route::post('/project-maps/all/{id}/report-delete', 'App\Http\Controllers\reportController@deleteMessage')->name('report-delete');

    Route::delete('/deleteRow/{id}', 'App\Http\Controllers\reportController@deleteRow')->name('deleteRow');


    //создание новой записи в карта проекта -> РИСКИ -> сохранение в БД
    Route::post('/project-maps/all/{id}/store-risks', 'App\Http\Controllers\risksController@store')->name('risks-store');
    Route::get('/getRiskData', 'App\Http\Controllers\risksController@getRiskData');


    // Route::get('/getRiskData', 'App\Http\Controllers\ProjectController@getRiskData')->name('getRiskData');

    Route::post('/project-maps/risk-update/{id}', 'App\Http\Controllers\risksController@update')->name('risks-update');

    Route::get('/project-maps/risk-delete/{id}', 'App\Http\Controllers\risksController@delete')->name('risks-delete');



    // обработка запросов поиска на странице все карты проекта
    Route::get('/search-projects', 'App\Http\Controllers\ProjectController@search')->name('search-projects');

    Route::get('/get-managers/{group}', 'App\Http\Controllers\ProjectController@getManagers')->name('getManagers');


    Route::post('/reestr-kp/store', 'App\Http\Controllers\RegReestrKPController@store')->name('reestr-kp.store');

    Route::get('/download-kp/{id}', 'App\Http\Controllers\RegReestrKPController@download')->name('download-kp');
    Route::get('/download-kp-additional/{id}', 'App\Http\Controllers\RegReestrKPController@downloadkpAdditional')->name('download-kpAdditional');

    Route::put('/reestr-kp/{id}', 'App\Http\Controllers\RegReestrKPController@update')->name('reestr-kp.update');

    Route::post('/update-note/{id}', 'App\Http\Controllers\RegReestrKPController@updateNote');


    Route::get('/get-kp-details/{id}', 'App\Http\Controllers\RegReestrKPController@getKPDetails')->name('get-kp-details');

    Route::put('/reestr-kp/additional-files/{id}', 'App\Http\Controllers\RegReestrKPController@updateAdditionalFile')->name('reestr-kp.updateAdditionalFile');

    Route::delete('/delete-kp/{id}', 'App\Http\Controllers\RegReestrKPController@deleteKP')->name('delete-kp');
    Route::delete('/delete-kp-additionalfile/{id}', 'App\Http\Controllers\RegReestrKPController@deleteAdditionalFile');
    // Route::delete('/reestr-kp/delete-word-file/{id}',  'App\Http\Controllers\RegReestrKPController@deleteWordFile')->name('reestr-kp.delete-word-file');

});