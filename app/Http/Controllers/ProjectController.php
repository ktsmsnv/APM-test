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
use App\Models\CalcRisk;

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
    public function showOneMessage($id)
    {
        $project = Projects::with('equipment', 'expenses', 'totals', 'markups', 'contacts', 'risks', 'notes', 'workGroup', 'basicReference', 'basicInfo', 'notes')->find($id); //'basicReference', 'basicInfo', 'notes'
        $notes = $project->notes;
        $baseRisks = baseRisks::all();
        return view('project-map', compact('project', 'notes', 'baseRisks'));
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
        return back();
    }
    //метод для удаления записи из дневника
    public function destroy(Projects $project, Note $note)
    {
        if ($project->projNum === $note->project_num) {
            $note->delete();
        }
        return back();
    }
    public function edit(Projects $project, Note $note)
    {
        return back();
    }
    public function update(Request $request, Projects $project, Note $note)
    {
        $note->update(['comment' => $request->comment]);
        $note->update(['date' => now()]);
        return back();
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

        return view('add-map', compact('projectNum', 'currentYear'));
    }

    // ДОБАВЛЕНИЕ   новой карты проекта
    public function storeNew(Request $request)
    {
        /* ---------------- РАСЧЕТ ----------------*/

        // общая информация
        $project = new Projects;
        // $project->projNum = $request->projNum;
        $project->projNum = $request->projNumPre . " " . $request->projNumSuf;
        $project->projManager = $request->projManager;
        $project->objectName = $request->objectName;
        $project->endCustomer = $request->endCustomer;
        $project->contractor = $request->contractor;
        $project->save();

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
                $item = array(
                    'project_num' => $project->projNum,
                    'calcRisk_name' => $risksData['riskName']
                );
                array_push($data_risks, $item);
            }
            CalcRisk::insert($data_risks);
        }

        return redirect()->route('project-maps');
    }



    // редактирование карты проекта -> РАСЧЕТ (открыывает страницу редактирования по id записи)
    public function updateCalculation($id)
    {
        $project = new Projects;
        return view('project-map-update', ['project' => $project->find($id)]);
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
        $project->save();
        Log::info('Processing change data:', [
            'project' => $project
        ]);
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
        // риски
        if ($req->has('risk')) {
            foreach ($req->input('risk') as $index => $risksData) {
                $criteria = [
                    'project_num' => $project->projNum,
                    'id' => $risksData['id'], // используйте идентификатор (id) записи, которую вы хотите обновить
                ];

                $updateData = [
                    'calcRisk_name' => $risksData['riskName'],
                ];

                CalcRisk::updateOrCreate($criteria, $updateData);
            }
        }

        return redirect()->route('project-data-one', $id)->with('success', 'Project data successfully updated');
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

        return redirect()->route('project-data-one', $id)->with('success', 'Project data successfully updated');
    }


    // редактирование карты проекта -> ИЗМЕНЕНИЯ (открыывает страницу редактирования по id записи)
    public function updateChanges($id)
    {
        $project = new Projects;
        return view('update-changes', ['project' => $project->find($id)]);
    }
    // РЕДАКТИРОВАНИЕ данных для карты проекта -> ИЗМЕНЕНИЯ
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

        return redirect()->route('project-data-one', $id)->with('success', 'Project data successfully updated');
    }



    public function search(Request $request)
    {
        $search_text = $request->input('search');
        
        $data = Projects::where('projManager', 'LIKE', '%'.$search_text.'%')
                        ->orWhere('projNum', 'LIKE', '%'.$search_text.'%')
                        ->orWhere('objectName', 'LIKE', '%'.$search_text.'%')
                        ->get();
    
        if ($data->isEmpty()) {
            // Выводим текст, если результаты поиска пусты
            return view('search', ['noResults' => true]);
        }
    
        return view('search', compact('data'));
    }
}
