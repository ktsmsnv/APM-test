<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Projects;
use App\Models\Equipment;
use App\Models\Expenses;
use App\Models\AdditionalExpense;
use App\Models\Note;
use App\Models\Total;
use App\Models\Markup;
use App\Models\contacts;
use App\Models\Risks;
use App\Models\BasicInfo;
use App\Models\BasicReference;
use App\Models\workGroup;
use App\Models\Change;
use App\Models\CalcRisk;
use App\Models\baseRisks;
use App\Models\ProjectManager;

use App\Models\RegEOB;
use App\Models\RegNHRS;
use App\Models\RegOther;
use App\Models\RegSInteg;

use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    // Отображение списка всех проектов на странице карты проекта
    public function allData()
    {
        // $projects = new Projects;
        $projects = Projects::paginate(3);
        return view('all-maps', ['data' => $projects]);
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

    // скачивание дневника
    public function exportNotesWord($id, $projNum)
    {
        // Загружаем данные из базы данных
        $project = Projects::find($id);

        // Проверяем, найден ли проект
        if (!$project) {
            return abort(404); // Вывести ошибку 404, если проект не найден
        }

        // Путь к существующему файлу Word
        $templatePath = storage_path("notes_template.docx");
        $templateProcessor = new TemplateProcessor($templatePath);
        
        // Получение данных из базы данных
        $notes = DB::table('notes')->where('project_num', $projNum)->get();

        $templateProcessor->cloneRow('date', count($notes));

        // Обход каждой строки данных и добавление значений в соответствующие ячейки
        foreach ($notes as $index => $note) {
            $templateProcessor->setValue('date#' . ($index + 1), $note->date);
            $templateProcessor->setValue('comment#' . ($index + 1), $note->comment);
        }

        $templateProcessor->setValue('projNum', $project->projNum);

         // Сохраняем измененный файл
         $newFilePath = storage_path("notes/дневник {$project->projNum}.docx");
         $templateProcessor->saveAs($newFilePath);
         
 
         // Возврат файла для загрузки
         return response()->download($newFilePath)->deleteFileAfterSend();
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
        /* ---------------- РАСЧЕТ (ОБЩАЯ ИНФА И КОНТАКТ ЛИСТ) ----------------*/

        // // общая информация
        // $project = new Projects;
        // // $project->projNum = $request->projNum;
        // $project->projNum = $request->projNumPre . " " . $request->projNumSuf;
        // $project->projNumSuf = $request->projNumSuf;

        // Определение количества проектов в выбранной группе
        $group = $request->projNumSuf;
        $lastProjectInGroup = Projects::where('projNumSuf', $group)->orderBy('id', 'desc')->first();

        // Определение номера проекта в пределах группы
        $projectNumberInGroup = ($lastProjectInGroup) ? explode('-', $lastProjectInGroup->projNum)[0] + 1 : 1;

        // Формирование номера проекта
        $projectNumber = $projectNumberInGroup . '-' . $request->projNumPre . ' ' . $group;

        // Создание записи проекта
        $project = new Projects;
        $project->projNum = $projectNumber;
        $project->projNumSuf = $group;

        $project->projManager = $request->projManager;
        $project->objectName = $request->objectName;
        $project->endCustomer = $request->endCustomer;
        $project->contractor = $request->contractor;

        $project->date_application = $request->date_application;
        // $project->date_offer = $request->date_offer;

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
            case 'Группа 1':
                $this->addToRegistrySinteg($project);
                break;
            case 'Группа 2':
                $this->addToRegistryEob($project);
                break;
            case 'Группа 3':
                $this->addToRegistryNhrs($project);
                break;
            case 'Группа 4':
                $this->addToRegistryOther($project);
                break;
            default:
                // Обработка, если тип не определен
                break;
        }

        // контакт лист
        if ($request->has('contacts')) {
            $data_contacts = array();
            foreach ($request->input('contacts') as $index => $contactsData) {
                $item = array(
                    'project_num' => $project->projNum,
                    'fio' => $contactsData['fio'],
                    'post' => $contactsData['post'],
                    'organization' => $contactsData['organization'],
                    'responsibility' => $contactsData['responsibility'],
                    'phone' => $contactsData['phone'],
                    'email' => $contactsData['email']
                );
                array_push($data_contacts, $item);
            }
            contacts::insert($data_contacts);
        }


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


    // редактирование карты проекта -> РАСЧЕТ (открыывает страницу редактирования по id записи)
    public function updateCalculation($id)
    {
        $project = Projects::find($id);
        $maxRiskId = CalcRisk::max('id');
        $projectManagers = ProjectManager::all();

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return view('project-map-update', [
            'project' => $project,
            'maxRiskId' => $maxRiskId,
            'projectManagers' => $projectManagers
        ]);
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
        $project->date_application = $req->input('date_application');
        $project->date_offer = $req->input('date_offer');

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
            case 'Группа 1':
                $this->updateRegistrySinteg($project);
                break;
            case 'Группа 2':
                $this->updateRegistryEob($project);
                break;
            case 'Группа 3':
                $this->updateRegistryNhrs($project);
                break;
            case 'Группа 4':
                $this->updateRegistryOther($project);
                break;
        }

        // Обновление оборудования
        if ($req->has('equipment')) {
            $totalPrice = 0;
            foreach ($req->input('equipment') as $equipmentData) {
                // Проверяем наличие идентификатора оборудования
                if (!empty($equipmentData['id'])) {
                    // Если есть идентификатор, ищем соответствующую запись в базе данных и обновляем её
                    $equipment = Equipment::find($equipmentData['id']);
                } else {
                    // Если идентификатор отсутствует, создаем новую запись
                    $equipment = new Equipment();
                }

                // Устанавливаем значение поля project_num
                $equipment->project_num = $project->projNum;

                $count = intval($equipmentData['count']);
                $priceUnit = floatval($equipmentData['priceUnit']);
                $price = $count * $priceUnit; // Расчёт стоимости

                // Заполнение или обновление данных оборудования
                $equipment->fill([
                    'nameTMC' => $equipmentData['nameTMC'],
                    'manufacture' => $equipmentData['manufacture'],
                    'unit' => $equipmentData['unit'],
                    'count' => $equipmentData['count'],
                    'priceUnit' => $equipmentData['priceUnit'],
                    'price' => $price, // запись в бд расчитанной стоимости
                ]);
                $totalPrice += $price;
                $equipment->save();
            }
        }



        // Прочие расходы
        $expenses = Expenses::where('project_num', $project->projNum)->firstOrFail();
        $total = 0;

        // Обработка основных расходов
        foreach ($req->input('expense') as $index => $expenseData) {
            foreach ($expenseData as $key => $value) {
                if ($key !== '_token') { // Пропускаем токен CSRF
                    $total += floatval($value);
                    // Обновляем значение в модели Expenses
                    $expenses->{$key} = $value;
                }
            }
        }

        // Обновление или создание записей о дополнительных расходах
        if ($req->has('additional_expenses')) {
            foreach ($req->input('additional_expenses') as $id => $additionalExpenseData) {
                $additionalExpense = AdditionalExpense::find($id);
                if ($additionalExpense) {
                    // Редактирование существующей записи
                    $additionalExpense->cost = $additionalExpenseData['cost'];
                    $additionalExpense->save();
                    $total += floatval($additionalExpenseData['cost']); // Добавляем стоимость к общей сумме
                } else {
                    // Добавление новой записи
                    $newAdditionalExpense = new AdditionalExpense;
                    $newAdditionalExpense->expense_id = $expenses->id; // Устанавливаем связь с основным расходом
                    $newAdditionalExpense->cost = $additionalExpenseData['cost'];
                    $newAdditionalExpense->save();
                    $total += floatval($additionalExpenseData['cost']); // Добавляем стоимость к общей сумме
                }
            }
        }

        // Сохранение общей стоимости расходов
        $expenses->total = $total;


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
                    'organization' => $contactsData['organization'],
                    'responsibility' => $contactsData['responsibility'],
                    'phone' => $contactsData['phone'],
                    'email' => $contactsData['email'],
                ];
                array_push($data_contacts, $item);
            }
            Contacts::insert($data_contacts);
        }
        // риски
        if ($req->has('risk')) {
            // Удаляем существующие риски проекта
            CalcRisk::where('project_num', $project->projNum)->delete();

            $data_risks = [];
            foreach ($req->input('risk') as $index => $riskData) {
                $item = [
                    'project_num' => $project->projNum,
                    'calcRisk_name' => $riskData['riskName'],
                ];
                array_push($data_risks, $item);
            }
            // Вставляем новые данные о рисках
            CalcRisk::insert($data_risks);
        }
        // if ($req->has('risk')) {
        //     foreach ($req->input('risk') as $index => $risksData) {
        //         $criteria = [
        //             'project_num' => $project->projNum,
        //         ];

        //         $updateData = [
        //             'calcRisk_name' => $risksData['riskName'],
        //         ];

        //         // Не указываем идентификатор, пусть база данных сама назначит автоинкрементный идентификатор
        //         CalcRisk::updateOrCreate($criteria, $updateData);
        //     }
        // }
        return redirect()->route('project-data-one', ['id' => $project->id, 'tab' => '#calculation'])->with('success', 'Project data successfully updated');
    }

    // ------------------- УДАЛЕНИЕ СТРОК ИЗ ТАБЛИЦЫ РАСЧЕТ ВО ВРЕМЯ РЕДАКТИРОВАНИЯ -----------------------------------
    public function deleteRow($table, $id)
    {
        $project = Projects::find($id);
        $model = null;

        switch ($table) {
            case 'equipment':
                $model = Equipment::find($id);
                break;
            case 'markups':
                $model = Markup::find($id);
                break;
            case 'contacts':
                $model = Contacts::find($id);
                break;
            case 'risks':
                $model = CalcRisk::find($id);
                break;
            case 'additional_expenses':
                $expense = AdditionalExpense::find($id);
                if ($expense) {
                    $expenseCost = $expense->cost;
                    $expense->delete();

                    // Пересчитываем параметр $total
                    $total = 0;
                    $expenses = Expenses::where('project_num', $project->projNum)->firstOrFail();
                    foreach ($expenses->additionalExpenses as $additionalExpense) {
                        $total += $additionalExpense->cost;
                    }
                    $expenses->total = $total;
                    $expenses->save();

                    return response()->json(['success' => true, 'expenseCost' => $expenseCost]);
                }
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Неизвестная таблица.']);
        }

        if ($model) {
            $model->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Запись не найдена.']);
        }
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
        $BasicReference->projCurator = $req->input('projCurator');
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
        $workGroup->projCurator = $req->projCurator2;
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
    // группа 1
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
    // группа 2
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
    // группа 3
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
    // группа 4
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
    // группа 1
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
    // группа 2
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
    // группа 3
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
    // группа 4
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

    // --------------- ВЫВОД СПИСКА РУКОВОДИТЕЛЕЙ ПРОЕКТА ----------------------------
    public function getManagers($group)
    {
        try {
            $managers = DB::table('project_managers')->where('groupNum', $group)->get();
            return response()->json($managers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // --------------- ДОБАВЛЕНИЕ ОБОРУДОВАНИЯ ----------------------------
    public function addEquipment($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
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
        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
    }
    // --------------- ДОБАВЛЕНИЕ ПРОЧИХ РАСХОДОВ  ----------------------------
    public function addExpenses($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
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

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
    }
    // --------------- ДОБАВЛЕНИЕ ИТОГО ----------------------------
    public function addTotals($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
        // таблица прочие расходы
        $expensesData = Expenses::where('project_num', $project->projNum)->first();
        $equipmentData = Equipment::where('project_num', $project->projNum)->first();

        // Check if expenses data is available
        if ($expensesData) {
            // Access individual expense fields
            $commandir = $expensesData->commandir;
            $rd = $expensesData->rd;
            $shmr = $expensesData->shmr;
            $pnr = $expensesData->pnr;
            $cert = $expensesData->cert;
            $delivery = $expensesData->delivery;
            $rastam = $expensesData->rastam;
            $ppo = $expensesData->ppo;
            $guarantee = $expensesData->guarantee;
            $check = $expensesData->check;

            $totalPrice = $equipmentData->price;

            // Calculate total from expense fields
            $total = $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check;

            // Calculate priceTotals
            $priceTotals = $totalPrice + $total;

            // Continue with the rest of your code
            $totals = new Total;
            $totals->project_num = $project->projNum;
            $totals->kdDays = $request->kdDays;
            $totals->equipmentDays = $request->equipmentDays;
            $totals->productionDays = $request->productionDays;
            $totals->shipmentDays = $request->shipmentDays;
            $totals->periodDays = $totals->kdDays + $totals->equipmentDays + $totals->productionDays + $totals->shipmentDays;
            $totals->price = $priceTotals;
            $totals->save();

            return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
        } else {
            // Handle the case when expenses data is not found
            return redirect()->back()->with('error', 'Expenses data not found for the project');
        }
    }
    // --------------- ДОБАВЛЕНИЕ УРОВНЯ НАЦЕНКИ ----------------------------
    public function addMarkups($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
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
        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
    }
    // --------------- ДОБАВЛЕНИЕ РИСКИ ----------------------------
    public function addRisks($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
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

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
    }



    // ------------------------ ПРОДОЛЖЕНИЕ ЗАПОЛНЕНИЯ КАРТЫ ПРОЕКТА -------------
    public function projectСontinue($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
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

        // $total =  $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check; // Расчёт всего
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

        // Получаем все дополнительные расходы из запроса и просуммируем их
        $additionalExpensesTotal = 0;
        if ($request->has('additional_expenses')) {
            foreach ($request->additional_expenses as $additionalExpense) {
                $additionalExpensesTotal += floatval($additionalExpense);
            }
        }
        // Подсчитываем общую сумму расходов, включая дополнительные расходы
        $total = $commandir + $rd + $shmr + $pnr + $cert + $delivery + $rastam + $ppo + $guarantee + $check + $additionalExpensesTotal;
        // Присваиваем общую сумму полю total в модели Expenses
        $expenses->total = $total;
        // Сохраняем основные расходы
        $expenses->save();

        // Теперь обрабатываем дополнительные расходы
        if ($request->has('additional_expenses')) {
            foreach ($request->additional_expenses as $additionalExpense) {
                $additional = new AdditionalExpense;
                $additional->expense_id = $expenses->id; // Привязываем к основному расходу
                $additional->cost = $additionalExpense;
                $additional->save();
            }
        }


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
        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#calculation'])->with('success', 'Project data successfully added');
    }
}
