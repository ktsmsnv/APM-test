<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Projects;
use App\Models\Equipment;
use App\Models\Expenses;
use App\Models\Note;
use App\Models\Total;
use App\Models\Markup;
use App\Models\contacts;
use App\Models\Risks;
use App\Models\BasicInfo;
use App\Models\BasicReference;
use App\Models\workGroup;
use App\Models\Change;
use App\Models\baseRisks;
use App\Models\ProjectManager;

use App\Models\RegEOB;
use App\Models\RegNHRS;
use App\Models\RegOther;
use App\Models\RegSInteg;

class ProjectController extends Controller
{
    // Отображение списка всех проектов на странице карты проекта
    public function allData()
    {
        // dd(Contact::all());
        $projects = new Projects;
        return view('all-maps', ['data' => $projects->all()]);
    }

    // Отображение одного проекта и связанных данных (отображает данные по id) на странице карты проекта
    public function showOneMessage($id, $tab = null)
    {
        $project = Projects::with('equipment', 'expenses', 'totals', 'markups', 'contacts', 'risks', 'workGroup', 'basicReference', 'basicInfo', 'notes')->find($id);

        if (!$project) {
            abort(404, 'Project not found');
        }

        $notes = $project->notes;
        $baseRisks = baseRisks::all();

        $defaultTab = 'calculation';

        if ($tab === null) {
            $tab = $defaultTab;
        }

        if (view()->exists("tables.{$tab}-projectMap")) {
            return view('project-map', compact('baseRisks', 'project', 'tab'));
        } else {
            abort(404, 'Tab not found');
        }
    }

    // удаление карты проекта (НЕАКТУАЛЬНО )
    public function deleteMessage($id)
    {
        Projects::find($id)->delete();
        return redirect()->route('project-maps')->with('success', 'сообщение было удалено');
    }


    //метод для сохранения новой записи в ДНЕВНИК
    public function store(Request $request, Projects $project)
    {
        $note = new Note;
        $note->comment = $request->comment;
        $note->date = now(); // указываем текущую дату
        $note->project_num = $project->projNum;
        $note->save();
        return redirect()->route('project-data-one', ['id' => $project->id, 'tab' => '#notes'])->with('success', 'Project data successfully updated');
    }
    //метод для удаления записи из дневника
    public function destroy(Projects $project, Note $note)
    {
        if ($project->projNum === $note->project_num) {
            $note->delete();
        }
        return redirect()->route('project-data-one', ['id' => $project->id, 'tab' => '#notes'])->with('success', 'Project data successfully updated');
    }
    public function edit(Projects $project, Note $note)
    {
        return back();
    }
    public function update(Request $request, Projects $project, Note $note)
    {
        $note->update(['comment' => $request->comment]);
        $note->update(['date' => now()]);
        return redirect()->route('project-data-one', ['id' => $project->id, 'tab' => '#notes'])->with('success', 'Project data successfully updated');
    }




    // переход на страницу СОЗДАНИЯ КАРТЫ ПРОЕКТА
    public function create()
    {
        $lastProject = Projects::latest('id')->first(); // Получаем последний проект (по наибольшему id)
        if ($lastProject) {
            $lastProjectNum = $lastProject->projNum;
            // Извлекаем номер из строки и увеличиваем его на 1
            $lastNumber = intval(substr($lastProjectNum, 0, strpos($lastProjectNum, '-')));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1; // Если нет проектов, начинаем с 1
        }
        $currentYear = date('y');
        $projectNum = $newNumber;

        $projectManagers = ProjectManager::all();
        $baseRisks = baseRisks::all();

        return view('add-map', compact('projectNum', 'currentYear', 'projectManagers', 'baseRisks'));
    }

    // ДОБАВЛЕНИЕ   новой карты проекта
    public function storeNew(Request $request)
    {
        /* ---------------- РАСЧЕТ ----------------*/

        // общая информация
        $project = new Projects;
        // $project->projNum = $request->projNum;
        $project->projNum = $request->projNumPre . " " . $request->projNumSuf;
        $project->projNumSuf = $request->projNumSuf;
        $project->projManager = $request->projManager;
        $project->objectName = $request->objectName;
        $project->endCustomer = $request->endCustomer;
        $project->contractor = $request->contractor;

        $project->date_application = $request->date_application;
        $project->date_offer = $request->date_offer;

        $project->delivery = $request->has('delivery') ? 1 : 0;
        $project->pir = $request->has('pir') ? 1 : 0;
        $project->kd = $request->has('kd') ? 1 : 0;
        $project->production = $request->has('production') ? 1 : 0;
        $project->smr = $request->has('smr') ? 1 : 0;
        $project->pnr = $request->has('pnr') ? 1 : 0;
        $project->po = $request->has('po') ? 1 : 0;
        $project->cmr = $request->has('cmr') ? 1 : 0;

        $project->save();

        switch ($request->projNumSuf) {
            case 'СИ':
                $this->addToRegistrySinteg($project);
                break;
            case 'ЭОБ':
                $this->addToRegistryEob($project);
                break;
            case 'НХРС':
                $this->addToRegistryNhrs($project);
                break;
            case 'КСТ':
                $this->addToRegistryOther($project);
                break;
            default:
                // Обработка, если тип не определен
                break;
        }

        // оборудование
        if ($request->has('equipment')) {
            $data_equipment = array();
            $totalPrice = 0;
            foreach ($request->input('equipment') as $index => $equipmentData) {
                // нахождения поля price(стоимость) путем умножения кол-ва на цену за ед. (count*priceUnit)
                $count = intval($equipmentData['count']);
                $priceUnit = floatval($equipmentData['priceUnit']);
                $price = $count * $priceUnit; // Расчёт стоимости

                $item = array(
                    'project_num' => $project->projNum,
                    'nameTMC' => $equipmentData['nameTMC'],
                    'manufacture' => $equipmentData['manufacture'],
                    'unit' => $equipmentData['unit'],
                    'count' => $equipmentData['count'],
                    'priceUnit' => $equipmentData['priceUnit'],
                    'price' => $price, //запись в бд расчитанной стоимости
                );
                array_push($data_equipment, $item);
                $totalPrice += $price;
            }
            Equipment::insert($data_equipment);
        }

        // прочие расходы
        $expenses = new Expenses;
        // нахождения поля total(всего) путем сложения значений всех полей
        $commandir = floatval($request->commandir);
        $rd = floatval($request->rd);
        $shmr = floatval($request->shmr);
        $pnr = floatval($request->pnr);
        $cert = floatval($request->cert);
        $delivery = floatval($request->delivery);
        $rastam = floatval($request->rastam);
        $ppo = floatval($request->ppo);
        $guarantee = floatval($request->guarantee);
        $check = floatval($request->check);
        $total =  $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check; // Расчёт всего
        $expenses->project_num = $project->projNum;
        $expenses->commandir = $request->commandir;
        $expenses->rd = $request->rd;
        $expenses->shmr = $request->shmr;
        $expenses->pnr = $request->pnr;
        $expenses->cert = $request->cert;
        $expenses->delivery = $request->delivery;
        $expenses->rastam = $request->rastam;
        $expenses->ppo = $request->ppo;
        $expenses->guarantee = $request->guarantee;
        $expenses->check = $request->check;

        $expenses->total =  $total;
        $expenses->save();

        // итого
        $totals = new Total;
        // нахождения поля periodDays(итого срок) путем сложения значений всех полей
        $kdDays = floatval($request->kdDays);
        $equipmentDays = floatval($request->equipmentDays);
        $productionDays = floatval($request->productionDays);
        $shipmentDays = floatval($request->shipmentDays);
        $periodDays = $kdDays + $equipmentDays + $productionDays + $shipmentDays; // Расчет итого
        // нахождения поля price(себестоимость) путем сложения поля всего из таблицы оборудования и всего из проч.расх.
        $priceTotals = ($totalPrice + $total);
        $totals->project_num = $project->projNum;
        $totals->kdDays = $request->kdDays;
        $totals->equipmentDays = $request->equipmentDays;
        $totals->productionDays = $request->productionDays;
        $totals->shipmentDays = $request->shipmentDays;

        $totals->periodDays = $periodDays;
        $totals->price = $priceTotals;
        $totals->save();

        // уровень наценки
        if ($request->has('markups')) {
            $data_markups = array();
            foreach ($request->input('markups') as $index => $markupsData) {
                $item = array(
                    'project_num' => $project->projNum,
                    'date' => $markupsData['date'],
                    'percentage' => $markupsData['percentage'],
                    'priceSubTkp' => $markupsData['priceSubTkp'],
                    'agreedFio' => $markupsData['agreedFio']
                );
                array_push($data_markups, $item);
            }
            Markup::insert($data_markups);
        }

        // контакт лист
        if ($request->has('contacts')) {
            $data_contacts = array();
            foreach ($request->input('contacts') as $index => $contactsData) {
                $item = array(
                    'project_num' => $project->projNum,
                    'fio' => $contactsData['fio'],
                    'post' => $contactsData['post'],
                    'responsibility' => $contactsData['responsibility'],
                    'contact' => $contactsData['contact']
                );
                array_push($data_contacts, $item);
            }
            contacts::insert($data_contacts);
        }

        // риски
        if ($request->has('risks')) {
            $data_risks = array();
            foreach ($request->input('risks') as $index => $risksData) {
                $risk_probability = intval($risksData['risk_probability']);
                $risk_influence = intval($risksData['risk_influence']);
                $risk_estimate = $risk_probability * $risk_influence; 
                $risk_strategy = ($risk_probability * $risk_influence) > 32
                ? 'снижение'
                : (($risk_probability * $risk_influence) == 0
                    ? null
                    : 'принятие');

                $item = array(
                    'risk_name' => $risksData['risk_name'],
                    'risk_reason' => json_encode($risksData['risk_reason']),
                    'risk_consequences' => json_encode($risksData['risk_consequences']),
                    'risk_probability' => intval($risksData['risk_probability']),
                    'risk_influence' => intval($risksData['risk_influence']),

                    'risk_estimate' =>  $risk_estimate,

                    'risk_strategy' => $risk_strategy,

                    'risk_counteraction' => json_encode($risksData['risk_counteraction']),
                    'risk_term' => $risksData['risk_term'],
                    'risk_mark' => $risksData['risk_mark'],
                    'risk_measures' => json_encode($risksData['risk_measures']),
                    'risk_responsible' => $risksData['risk_resp'],
                    'risk_endTerm' => $risksData['risk_endTerm']
                );
                array_push($data_risks, $item);
            }
            Risks::insert($data_risks);
        }

        // if ($request->has('risks')) {
        //     foreach ($request->input('risks') as $index => $risksData) {
        //         $risk = new Risks();

        //         $risk->risk_reason = json_encode($risksData['risk_reason']);
        //         $risk->risk_consequences = json_encode($risksData['risk_consequences']);
        //         $risk->risk_counteraction = json_encode($risksData['risk_counteraction']);
        //         $risk->risk_measures = json_encode($risksData['risk_measures']);

        //         $risk->risk_name = $risksData['risk_name'];

        //         $risk->risk_probability = intval($risksData['risk_probability']);
        //         $risk->risk_influence = intval($risksData['risk_influence']);
        //         $risk->risk_estimate = $risk->risk_probability * $risk->risk_influence;
        //         $risk->risk_strategy = $risk->risk_estimate > 32 ? 'снижение' : ($risk->risk_estimate == 0 ? null : 'принятие');
        //         $risk->risk_term = $risksData['risk_term'];
        //         $risk->risk_mark = $risksData['risk_mark'];
        //         $risk->risk_responsible = $risksData['risk_resp'];
        //         $risk->risk_endTerm = $risksData['risk_endTerm'];
        //         $project->risks()->save($risk);
        //     }
        // }


        return redirect()->route('project-maps');
    }

    // Метод для получения данных по выбранному риску
    public function getRiskData(Request $request)
    {
        // Получаем выбранный риск из запроса
        $selectedRisk = $request->input('risk');

        $baseRisk = baseRisks::where('nameRisk', $selectedRisk)->first();

        if ($baseRisk) {
            // Возвращаем данные в формате JSON
            return response()->json([
                'reasonData' => json_decode($baseRisk->reasonRisk),
                'consequenceData' => json_decode($baseRisk->conseqRiskOnset),
                'counteringRiskData' => json_decode($baseRisk->counteringRisk),
                'riskManagMeasuresData' => json_decode($baseRisk->riskManagMeasures),
                'term' => $baseRisk->term,
            ]);
        } else {
            // Риск не найден
            return response()->json(['error' => 'Риск не найден'], 404);
        }
    }



    // АВТОСОХРАНЕНИЕ ДАННЫХ
    // public function autoSave(Request $request)
    // {
    //     // Проверка, была ли нажата кнопка "Отмена"
    //     if ($request->has('cancelButton')) {
    //         // Удаление созданной записи, если она есть
    //         Projects::where('projNum', $request->projNumPre . " " . $request->projNumSuf)->delete();
    //         return response()->json(['message' => 'Сохранение отменено']);
    //     }


    //     // Поиск записи по projNum
    //     $project = Projects::where('projNum', $request->projNumPre . " " . $request->projNumSuf)->first();

    //     if ($project) {
    //         // Обновление существующей записи
    //         $project->projManager = $request->projManager;
    //         $project->objectName = $request->objectName;
    //         $project->endCustomer = $request->endCustomer;
    //         $project->contractor = $request->contractor;
    //         $project->save();
    //         // оборудование
    //         if ($request->has('equipment')) {
    //             $data_equipment = array();
    //             $totalPrice = 0;
    //             foreach ($request->input('equipment') as $index => $equipmentData) {
    //                 // нахождения поля price(стоимость) путем умножения кол-ва на цену за ед. (count*priceUnit)
    //                 $count = intval($equipmentData['count']);
    //                 $priceUnit = floatval($equipmentData['priceUnit']);
    //                 $price = $count * $priceUnit; // Расчёт стоимости

    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'nameTMC' => $equipmentData['nameTMC'],
    //                     'manufacture' => $equipmentData['manufacture'],
    //                     'unit' => $equipmentData['unit'],
    //                     'count' => $equipmentData['count'],
    //                     'priceUnit' => $equipmentData['priceUnit'],
    //                     'price' => $price, //запись в бд расчитанной стоимости
    //                 );
    //                 array_push($data_equipment, $item);
    //                 $totalPrice += $price;
    //             }
    //             Equipment::insert($data_equipment);
    //         }
    //         // прочие расходы
    //         $expenses = new Expenses;
    //         // нахождения поля total(всего) путем сложения значений всех полей
    //         $commandir = floatval($request->commandir);
    //         $rd = floatval($request->rd);
    //         $shmr = floatval($request->shmr);
    //         $pnr = floatval($request->pnr);
    //         $cert = floatval($request->cert);
    //         $delivery = floatval($request->delivery);
    //         $rastam = floatval($request->rastam);
    //         $ppo = floatval($request->ppo);
    //         $guarantee = floatval($request->guarantee);
    //         $check = floatval($request->check);
    //         $total =  $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check; // Расчёт всего
    //         $expenses->project_num = $project->projNum;
    //         $expenses->commandir = $request->commandir;
    //         $expenses->rd = $request->rd;
    //         $expenses->shmr = $request->shmr;
    //         $expenses->pnr = $request->pnr;
    //         $expenses->cert = $request->cert;
    //         $expenses->delivery = $request->delivery;
    //         $expenses->rastam = $request->rastam;
    //         $expenses->ppo = $request->ppo;
    //         $expenses->guarantee = $request->guarantee;
    //         $expenses->check = $request->check;

    //         $expenses->total =  $total;
    //         $expenses->save();

    //         // итого
    //         $totals = new Total;
    //         // нахождения поля periodDays(итого срок) путем сложения значений всех полей
    //         $kdDays = floatval($request->kdDays);
    //         $equipmentDays = floatval($request->equipmentDays);
    //         $productionDays = floatval($request->productionDays);
    //         $shipmentDays = floatval($request->shipmentDays);
    //         $periodDays = $kdDays + $equipmentDays + $productionDays + $shipmentDays; // Расчет итого
    //         // нахождения поля price(себестоимость) путем сложения поля всего из таблицы оборудования и всего из проч.расх.
    //         $priceTotals = ($totalPrice + $total);
    //         $totals->project_num = $project->projNum;
    //         $totals->kdDays = $request->kdDays;
    //         $totals->equipmentDays = $request->equipmentDays;
    //         $totals->productionDays = $request->productionDays;
    //         $totals->shipmentDays = $request->shipmentDays;

    //         $totals->periodDays = $periodDays;
    //         $totals->price = $priceTotals;
    //         $totals->save();

    //         // уровень наценки
    //         if ($request->has('markups')) {
    //             $data_markups = array();
    //             foreach ($request->input('markups') as $index => $markupsData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'date' => $markupsData['date'],
    //                     'percentage' => $markupsData['percentage'],
    //                     'priceSubTkp' => $markupsData['priceSubTkp'],
    //                     'agreedFio' => $markupsData['agreedFio']
    //                 );
    //                 array_push($data_markups, $item);
    //             }
    //             Markup::insert($data_markups);
    //         }
    //         // контакт лист
    //         if ($request->has('contacts')) {
    //             $data_contacts = array();
    //             foreach ($request->input('contacts') as $index => $contactsData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'fio' => $contactsData['fio'],
    //                     'post' => $contactsData['post'],
    //                     'responsibility' => $contactsData['responsibility'],
    //                     'contact' => $contactsData['contact']
    //                 );
    //                 array_push($data_contacts, $item);
    //             }
    //             contacts::insert($data_contacts);
    //         }
    //         // риски
    //         if ($request->has('risks')) {
    //             $data_risks = array();
    //             foreach ($request->input('risks') as $index => $risksData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'calcRisk_name' => $risksData['riskName']
    //                 );
    //                 array_push($data_risks, $item);
    //             }
    //             CalcRisk::insert($data_risks);
    //         }
    //     } else {
    //         // Создание новой записи
    //         $project = new Projects;
    //         $project->projNum = $request->projNumPre . " " . $request->projNumSuf;
    //         $project->projManager = $request->projManager;
    //         $project->objectName = $request->objectName;
    //         $project->endCustomer = $request->endCustomer;
    //         $project->contractor = $request->contractor;
    //         $project->save();
    //         // оборудование
    //         if ($request->has('equipment')) {
    //             $data_equipment = array();
    //             $totalPrice = 0;
    //             foreach ($request->input('equipment') as $index => $equipmentData) {
    //                 // нахождения поля price(стоимость) путем умножения кол-ва на цену за ед. (count*priceUnit)
    //                 $count = intval($equipmentData['count']);
    //                 $priceUnit = floatval($equipmentData['priceUnit']);
    //                 $price = $count * $priceUnit; // Расчёт стоимости

    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'nameTMC' => $equipmentData['nameTMC'],
    //                     'manufacture' => $equipmentData['manufacture'],
    //                     'unit' => $equipmentData['unit'],
    //                     'count' => $equipmentData['count'],
    //                     'priceUnit' => $equipmentData['priceUnit'],
    //                     'price' => $price, //запись в бд расчитанной стоимости
    //                 );
    //                 array_push($data_equipment, $item);
    //                 $totalPrice += $price;
    //             }
    //             Equipment::insert($data_equipment);
    //         }
    //         // прочие расходы
    //         $expenses = new Expenses;
    //         // нахождения поля total(всего) путем сложения значений всех полей
    //         $commandir = floatval($request->commandir);
    //         $rd = floatval($request->rd);
    //         $shmr = floatval($request->shmr);
    //         $pnr = floatval($request->pnr);
    //         $cert = floatval($request->cert);
    //         $delivery = floatval($request->delivery);
    //         $rastam = floatval($request->rastam);
    //         $ppo = floatval($request->ppo);
    //         $guarantee = floatval($request->guarantee);
    //         $check = floatval($request->check);
    //         $total =  $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check; // Расчёт всего
    //         $expenses->project_num = $project->projNum;
    //         $expenses->commandir = $request->commandir;
    //         $expenses->rd = $request->rd;
    //         $expenses->shmr = $request->shmr;
    //         $expenses->pnr = $request->pnr;
    //         $expenses->cert = $request->cert;
    //         $expenses->delivery = $request->delivery;
    //         $expenses->rastam = $request->rastam;
    //         $expenses->ppo = $request->ppo;
    //         $expenses->guarantee = $request->guarantee;
    //         $expenses->check = $request->check;

    //         $expenses->total =  $total;
    //         $expenses->save();

    //         // итого
    //         $totals = new Total;
    //         // нахождения поля periodDays(итого срок) путем сложения значений всех полей
    //         $kdDays = floatval($request->kdDays);
    //         $equipmentDays = floatval($request->equipmentDays);
    //         $productionDays = floatval($request->productionDays);
    //         $shipmentDays = floatval($request->shipmentDays);
    //         $periodDays = $kdDays + $equipmentDays + $productionDays + $shipmentDays; // Расчет итого
    //         // нахождения поля price(себестоимость) путем сложения поля всего из таблицы оборудования и всего из проч.расх.
    //         $priceTotals = ($totalPrice + $total);
    //         $totals->project_num = $project->projNum;
    //         $totals->kdDays = $request->kdDays;
    //         $totals->equipmentDays = $request->equipmentDays;
    //         $totals->productionDays = $request->productionDays;
    //         $totals->shipmentDays = $request->shipmentDays;

    //         $totals->periodDays = $periodDays;
    //         $totals->price = $priceTotals;
    //         $totals->save();

    //         // уровень наценки
    //         if ($request->has('markups')) {
    //             $data_markups = array();
    //             foreach ($request->input('markups') as $index => $markupsData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'date' => $markupsData['date'],
    //                     'percentage' => $markupsData['percentage'],
    //                     'priceSubTkp' => $markupsData['priceSubTkp'],
    //                     'agreedFio' => $markupsData['agreedFio']
    //                 );
    //                 array_push($data_markups, $item);
    //             }
    //             Markup::insert($data_markups);
    //         }
    //         // контакт лист
    //         if ($request->has('contacts')) {
    //             $data_contacts = array();
    //             foreach ($request->input('contacts') as $index => $contactsData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'fio' => $contactsData['fio'],
    //                     'post' => $contactsData['post'],
    //                     'responsibility' => $contactsData['responsibility'],
    //                     'contact' => $contactsData['contact']
    //                 );
    //                 array_push($data_contacts, $item);
    //             }
    //             contacts::insert($data_contacts);
    //         }
    //         // риски
    //         if ($request->has('risks')) {
    //             $data_risks = array();
    //             foreach ($request->input('risks') as $index => $risksData) {
    //                 $item = array(
    //                     'project_num' => $project->projNum,
    //                     'calcRisk_name' => $risksData['riskName']
    //                 );
    //                 array_push($data_risks, $item);
    //             }
    //             CalcRisk::insert($data_risks);
    //         }
    //     }

    //     return response()->json(['message' => 'Данные успешно автосохранены']);
    // }



    // редактирование карты проекта -> РАСЧЕТ (открыывает страницу редактирования по id записи)
    public function updateCalculation($id)
    {
        $project = Projects::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return view('project-map-update', ['project' => $project]);
    }
    // РЕДАКТИРОВАНИЕ данных для карты проекта -> РАСЧЕТ
    public function updateCalculationSubmit($id, Request $req)
    {
        // --------------РАСЧЕТ----------------//
        // Обновление общая информация по проекту
        $project = Projects::find($id);
        // $project->projNum = $req->input('projNum');
        $project->projManager = $req->input('projManager');
        $project->objectName = $req->input('objectName');
        $project->endCustomer = $req->input('endCustomer');
        $project->contractor = $req->input('contractor');
        $project->contractor = $req->input('date_application');
        $project->contractor = $req->input('date_offer');

        $project->delivery = $req->has('delivery') ? 1 : 0;
        $project->pir = $req->has('pir') ? 1 : 0;
        $project->kd = $req->has('kd') ? 1 : 0;
        $project->production = $req->has('production') ? 1 : 0;
        $project->smr = $req->has('smr') ? 1 : 0;
        $project->pnr = $req->has('pnr') ? 1 : 0;
        $project->po = $req->has('po') ? 1 : 0;
        $project->cmr = $req->has('cmr') ? 1 : 0;

        $project->save();

        switch ($project->projNumSuf) {
            case 'СИ':
                $this->updateRegistrySinteg($project);
                break;
            case 'ЭОБ':
                $this->updateRegistryEob($project);
                break;
            case 'НХРС':
                $this->updateRegistryNhrs($project);
                break;
            case 'КСТ':
                $this->updateRegistryOther($project);
                break;
        }

        // Обновление оборудование
        if ($req->has('equipment')) {
            $totalPrice = 0;
            foreach ($req->input('equipment') as $equipmentData) {
                $equipment = Equipment::find($equipmentData['id']);

                $count = intval($equipmentData['count']);
                $priceUnit = floatval($equipmentData['priceUnit']);
                $price = $count * $priceUnit; // Расчёт стоимости

                if ($equipment) {
                    $equipment->fill([
                        'nameTMC' => $equipmentData['nameTMC'],
                        'manufacture' => $equipmentData['manufacture'],
                        'unit' => $equipmentData['unit'],
                        'count' => $equipmentData['count'],
                        'priceUnit' => $equipmentData['priceUnit'],
                        'price' => $price, //запись в бд расчитанной стоимости
                    ]);
                    $totalPrice += $price;
                    $equipment->save();
                }
            }
        }
        // прочие расходы
        $expenses = Expenses::where('project_num', $project->projNum)->first();
        $commandir = floatval($req->commandir);
        $rd = floatval($req->rd);
        $shmr = floatval($req->shmr);
        $pnr = floatval($req->pnr);
        $cert = floatval($req->cert);
        $delivery = floatval($req->delivery);
        $rastam = floatval($req->rastam);
        $ppo = floatval($req->ppo);
        $guarantee = floatval($req->guarantee);
        $check = floatval($req->check);
        $total =  $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check; // Расчёт всего
        $expenses->project_num = $project->projNum;
        $expenses->commandir = $req->commandir;
        $expenses->rd = $req->rd;
        $expenses->shmr = $req->shmr;
        $expenses->pnr = $req->pnr;
        $expenses->cert = $req->cert;
        $expenses->delivery = $req->delivery;
        $expenses->rastam = $req->rastam;
        $expenses->ppo = $req->ppo;
        $expenses->guarantee = $req->guarantee;
        $expenses->check = $req->check;
        $expenses->total =  $total;
        $expenses->save();

        //итого
        $totals = Total::where('project_num', $project->projNum)->first();
        if ($totals) {
            $kdDays = floatval($req->kdDays);
            $equipmentDays = floatval($req->equipmentDays);
            $productionDays = floatval($req->productionDays);
            $shipmentDays = floatval($req->shipmentDays);

            $periodDays = $kdDays + $equipmentDays + $productionDays + $shipmentDays; // Расчет итого
            // нахождения поля price(себестоимость) путем сложения поля всего из таблицы оборудования и всего из проч.расх.
            $priceTotals = ($totalPrice + $total);
            $totals->fill([
                'periodDays' => $periodDays,
                'price' => $priceTotals,
                'kdDays' => $kdDays,
                'equipmentDays' => $equipmentDays,
                'productionDays' => $productionDays,
                'shipmentDays' => $shipmentDays,
            ]);
            $totals->save();
        }
        //уровень наценки
        if ($req->has('markup')) {
            Markup::where('project_num', $project->projNum)->delete();
            $data_markups = [];
            foreach ($req->input('markup') as $index => $markupsData) {
                $item = [
                    'project_num' => $project->projNum,
                    'date' => $markupsData['date'],
                    'percentage' => $markupsData['percentage'],
                    'priceSubTkp' => $markupsData['priceSubTkp'],
                    'agreedFio' => $markupsData['agreedFio'],
                ];
                array_push($data_markups, $item);
            }
            Markup::insert($data_markups);
        }
        // контакт лист
        if ($req->has('contact')) {
            Contacts::where('project_num', $project->projNum)->delete();
            $data_contacts = [];
            foreach ($req->input('contact') as $index => $contactsData) {
                $item = [
                    'project_num' => $project->projNum,
                    'fio' => $contactsData['fio'],
                    'post' => $contactsData['post'],
                    'responsibility' => $contactsData['responsibility'],
                    'contact' => $contactsData['contact'],
                ];
                array_push($data_contacts, $item);
            }
            Contacts::insert($data_contacts);
        }
        // // риски
        // if ($req->has('risk')) {
        //     foreach ($req->input('risk') as $index => $risksData) {
        //         $criteria = [
        //             'project_num' => $project->projNum,
        //             'id' => $risksData['id'], // используйте идентификатор (id) записи, которую вы хотите обновить
        //         ];

        //         $updateData = [
        //             'calcRisk_name' => $risksData['riskName'],
        //         ];

        //         CalcRisk::updateOrCreate($criteria, $updateData);
        //     }
        // }

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully updated');
    }


    // редактирование карты проекта -> РЕАЛИЗАЦИЯ (открыывает страницу редактирования по id записи)
    public function updateRealization($id)
    {
        $project = new Projects;
        return view('update-realization', ['project' => $project->find($id)]);
    }
    // РЕДАКТИРОВАНИЕ данных для карты проекта -> РЕАЛИЗАЦИЯ
    public function updateRealizationSubmit($id, Request $req)
    {
        $project = Projects::find($id);
        // --------------РЕАЛИЗАЦИЯ----------------//
        // базовая справка
        $BasicReference = BasicReference::where('project_num', $project->projNum)->first();
        $BasicReference->projName = $req->input('projName');
        // $BasicReference->projCustomer = $project->endCustomer = $req->input('endCustomer');
        $BasicReference->projCustomer = $project->endCustomer;
        $BasicReference->startDate = $req->input('startDate');
        $BasicReference->endDate = $req->input('endDate');
        $BasicReference->projGoal = $req->input('projGoal');
        $BasicReference->projCurator = $req->input('projCurator2');
        $BasicReference->projManager = $req->input('projManager');
        $BasicReference->save();

        // доп информация
        $BasicInfo = BasicInfo::where('project_num', $project->projNum)->first();
        $BasicInfo->contractor = $req->contractor;
        $BasicInfo->contract_num = $req->contract_num;
        // $BasicInfo->price_plan = $request->price_plan;
        $BasicInfo->price_plan = $project->totals->first()->price;
        $BasicInfo->price_fact = $req->price_fact;
        $BasicInfo->contract_price = $req->contract_price;
        // расчет полей
        $contract_price = floatval($req->contract_price);
        $price_plan = floatval($req->price_plan);
        $price_fact = floatval($req->price_fact);
        // нахождения поля profit_plan(прибыль план) путем разницы стоим.контракта и себестоимость план
        $profit_plan = ($contract_price - $price_plan);
        // нахождения поля profit_fact(прибыль факт) путем разницы стоим.контракта и себестоимость факт
        $profit_fact = ($contract_price - $price_fact);
        // вывод расчитанных полей
        $BasicInfo->profit_plan = $profit_plan;
        $BasicInfo->profit_fact = $profit_fact;

        $BasicInfo->start_date = $req->start_date;
        $BasicInfo->end_date_plan = $req->end_date_plan;

        $BasicInfo->end_date_fact = $req->end_date_fact;
        $BasicInfo->complaint = $req->complaint;
        $BasicInfo->save();

        // Состав рабочей группы и ответственность
        $workGroup = workGroup::where('project_num', $project->projNum)->first();
        $workGroup->projCurator = $req->projCurator;
        $workGroup->projDirector = $req->projDirector;
        $workGroup->techlid = $req->techlid;
        $workGroup->production = $req->production;
        $workGroup->supply = $req->supply;
        $workGroup->logistics = $req->logistics;
        $workGroup->save();

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#realization'])->with('success', 'Project data successfully updated');
    }

    // редактирование карты проекта -> ИЗМЕНЕНИЯ (открыывает страницу редактирования по id записи)
    public function updateChanges($id)
    {
        $project = Projects::find($id);
        return view('update-changes', ['project' => $project]);
    }

    public function updateChangesSubmit($id, Request $req)
    {
        $project = Projects::find($id);

        // Ensure the request has the 'changes' key and it's an array
        if ($req->has('changes') && is_array($req->input('changes'))) {
            foreach ($req->input('changes') as $index => $ChangesData) {
                $change = Change::updateOrCreate(
                    [
                        'project_num' => $project->projNum,
                        'contract_num' => $ChangesData['contract_num'],
                        'contractor' => $ChangesData['contractor'],
                        'id' => $ChangesData['id'],
                    ],
                    [
                        'id' => $ChangesData['id'],
                        'change' => $ChangesData['change'],
                        'impact' => $ChangesData['impact'],
                        'stage' => $ChangesData['stage'],
                        'corrective' => $ChangesData['corrective'],
                        'responsible' => $ChangesData['responsible'],
                    ]
                );
            }
        }

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#changes'])->with('success', 'Project data successfully updated');
    }



    public function search(Request $request)
    {
        $search_text = $request->input('search');

        $data = Projects::where('projManager', 'LIKE', '%' . $search_text . '%')
            ->orWhere('projNum', 'LIKE', '%' . $search_text . '%')
            ->orWhere('objectName', 'LIKE', '%' . $search_text . '%')
            ->get();

        if ($data->isEmpty()) {
            // Выводим текст, если результаты поиска пусты
            return view('search', ['noResults' => true]);
        }

        return view('search', compact('data'));
    }



    // --------------- ДОБАВЛЕНИЕ В РЕЕСТР -----------------------------
    private function addToRegistryEob($project)
    {
        RegEob::create([
            'vnNum' => $project->projNum,
            'purchaseName' => $project->objectName,
            'delivery' => $project->delivery,
            'pir' => $project->pir,
            'kd' => $project->kd,
            'prod' => $project->production,
            'shmr' => $project->smr,
            'pnr' => $project->pnr,
            'po' => $project->po,
            'smr' => $project->cmr,
            'purchaseOrg' => $project->contractor,
            'endUser' => $project->endCustomer,
            'object' => $project->objectName,
            'receiptDate' => $project->date_application,
            'submissionDate' => $project->date_offer,
            'projectManager' => $project->projManager,
        ]);
    }
    private function addToRegistrySinteg($project)
    {
        RegSInteg::create([
            'vnNum' => $project->projNum,
            'purchaseName' => $project->objectName,
            'delivery' => $project->delivery,
            'pir' => $project->pir,
            'kd' => $project->kd,
            'prod' => $project->production,
            'shmr' => $project->smr,
            'pnr' => $project->pnr,
            'po' => $project->po,
            'smr' => $project->cmr,
            'purchaseOrg' => $project->contractor,
            'endUser' => $project->endCustomer,
            'object' => $project->objectName,
            'receiptDate' => $project->date_application,
            'submissionDate' => $project->date_offer,
            'projectManager' => $project->projManager,
        ]);
    }
    private function addToRegistryNhrs($project)
    {
        RegNHRS::create([
            'vnNum' => $project->projNum,
            'purchaseName' => $project->objectName,
            'delivery' => $project->delivery,
            'pir' => $project->pir,
            'kd' => $project->kd,
            'prod' => $project->production,
            'shmr' => $project->smr,
            'pnr' => $project->pnr,
            'po' => $project->po,
            'smr' => $project->cmr,
            'purchaseOrg' => $project->contractor,
            'endUser' => $project->endCustomer,
            'object' => $project->objectName,
            'receiptDate' => $project->date_application,
            'submissionDate' => $project->date_offer,
            'projectManager' => $project->projManager,
        ]);
    }
    private function addToRegistryOther($project)
    {
        RegOther::create([
            'vnNum' => $project->projNum,
            'purchaseName' => $project->objectName,
            'delivery' => $project->supply,
            'pir' => $project->pir,
            'kd' => $project->kd,
            'prod' => $project->production,
            'shmr' => $project->smr,
            'pnr' => $project->pnr,
            'po' => $project->po,
            'smr' => $project->cmr,
            'purchaseOrg' => $project->contractor,
            'endUser' => $project->endCustomer,
            'object' => $project->objectName,
            'receiptDate' => $project->date_application,
            'submissionDate' => $project->date_offer,
            'projectManager' => $project->projManager,
        ]);
    }

    // --------------- ИЗМЕНЕНИЯ В РЕЕСТРЕ ИЗ КАРТЫ ПРОЕКТА ----------------------------
    private function updateRegistryEob($project)
    {
        $registry = RegEob::where('vnNum', $project->projNum)->first();

        if ($registry) {
            $registry->update([
                'purchaseName' => $project->objectName,
                'delivery' => $project->delivery,
                'pir' => $project->pir,
                'kd' => $project->kd,
                'prod' => $project->production,
                'shmr' => $project->smr,
                'pnr' => $project->pnr,
                'po' => $project->po,
                'smr' => $project->cmr,
                'purchaseOrg' => $project->contractor,
                'endUser' => $project->endCustomer,
                'object' => $project->objectName,
                'receiptDate' => $project->date_application,
                'submissionDate' => $project->date_offer,
                'projectManager' => $project->projManager,
            ]);
        }
    }

    private function updateRegistrySinteg($project)
    {
        $registry = RegSInteg::where('vnNum', $project->projNum)->first();

        if ($registry) {
            $registry->update([
                'purchaseName' => $project->objectName,
                'delivery' => $project->delivery,
                'pir' => $project->pir,
                'kd' => $project->kd,
                'prod' => $project->production,
                'shmr' => $project->smr,
                'pnr' => $project->pnr,
                'po' => $project->po,
                'smr' => $project->cmr,
                'purchaseOrg' => $project->contractor,
                'endUser' => $project->endCustomer,
                'object' => $project->objectName,
                'receiptDate' => $project->date_application,
                'submissionDate' => $project->date_offer,
                'projectManager' => $project->projManager,
            ]);
        }
    }

    private function updateRegistryNhrs($project)
    {
        $registry = RegNHRS::where('vnNum', $project->projNum)->first();

        if ($registry) {
            $registry->update([
                'purchaseName' => $project->objectName,
                'delivery' => $project->delivery,
                'pir' => $project->pir,
                'kd' => $project->kd,
                'prod' => $project->production,
                'shmr' => $project->smr,
                'pnr' => $project->pnr,
                'po' => $project->po,
                'smr' => $project->cmr,
                'purchaseOrg' => $project->contractor,
                'endUser' => $project->endCustomer,
                'object' => $project->objectName,
                'receiptDate' => $project->date_application,
                'submissionDate' => $project->date_offer,
                'projectManager' => $project->projManager,
            ]);
        }
    }

    private function updateRegistryOther($project)
    {
        $registry = RegOther::where('vnNum', $project->projNum)->first();

        if ($registry) {
            $registry->update([
                'purchaseName' => $project->objectName,
                'delivery' => $project->delivery,
                'pir' => $project->pir,
                'kd' => $project->kd,
                'prod' => $project->production,
                'shmr' => $project->smr,
                'pnr' => $project->pnr,
                'po' => $project->po,
                'smr' => $project->cmr,
                'purchaseOrg' => $project->contractor,
                'endUser' => $project->endCustomer,
                'object' => $project->objectName,
                'receiptDate' => $project->date_application,
                'submissionDate' => $project->date_offer,
                'projectManager' => $project->projManager,
            ]);
        }
    }
}
