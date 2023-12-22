<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Report;
use App\Models\ReportNotes;
use App\Models\ReportReflection;
use App\Models\ReportTeam;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;


class reportController extends Controller
{

    // Отображение данных из расчета
    public function showDataCalculation($id)
    {
        $project = Projects::with('equipment', 'expenses', 'totals', 'markups', 'contacts', 'risks', 'basicReference', 'basicInfo',  'ReportTeam')->find($id);
        return view('report-projectMap', compact('project'));
    }


    // сохранение полей в бд
    public function store(Request $request, $id)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
        // отчет
        $Report = new Report;
        $Report->project_num = $project->projNum;
        $Report->costRubW = $request->costRubW;
        $Report->costRub = $request->costRub;
        $Report->expenseDirectPlan = $request->expenseDirectPlan;
        $Report->expenseMaterialPlan = $request->expenseMaterialPlan;
        $Report->expenseDeliveryPlan = $request->expenseDeliveryPlan;
        $Report->expenseWorkPlan = $request->expenseWorkPlan;
        $Report->expenseOtherPlan = $request->expenseOtherPlan;
        $Report->expenseOpoxPlan = $request->expenseOpoxPlan;
        $Report->marginProfitPlan = $request->marginProfitPlan;
        $Report->marginalityPlan = $request->marginalityPlan;
        $Report->profitPlan = $request->profitPlan;
        $Report->projProfitPlan = $request->projProfitPlan;
        $Report->expenseDirectFact = $request->expenseDirectFact;
        $Report->expenseMaterialFact = $request->expenseMaterialFact;
        $Report->expenseDeliveryFact = $request->expenseDeliveryFact;
        $Report->expenseWorkFact = $request->expenseWorkFact;
        $Report->expenseOtherFact = $request->expenseOtherFact;
        $Report->expenseOpoxFact = $request->expenseOpoxFact;
        $Report->marginProfitFact = $request->marginProfitFact;
        $Report->marginalityFact = $request->marginalityFact;
        $Report->profitFact     = $request->profitFact;
        $Report->projProfitFact = $request->projProfitFact;
        $Report->save();

        //команда проекта
        if ($request->has('roles')) {
            $data_roles = array();
            foreach ($request->input('roles') as $index => $rolesData) {

                $item = array(
                    'project_num' => $project->projNum,
                    'roleFio' => $rolesData['roleFio'],
                    'roleDescription' => $rolesData['roleDescription'],
                    'roleImpact' => $rolesData['roleImpact'],
                    'roleBonus' => $rolesData['roleBonus'],
                    'premium_part' => $rolesData['premium_part'],
                );
                array_push($data_roles, $item);
            }
            ReportTeam::insert($data_roles);
        }


        //Рефлексия по проекту
        $ReportReflection = new ReportReflection;
        $ReportReflection->project_num = $project->projNum;
        $ReportReflection->devRKD_adv = $request->devRKD_adv;
        $ReportReflection->complection_adv = $request->complection_adv;
        $ReportReflection->production_adv = $request->production_adv;
        $ReportReflection->shipment_adv = $request->shipment_adv;
        $ReportReflection->devRKD_dis = $request->devRKD_dis;
        $ReportReflection->complection_dis = $request->complection_dis;
        $ReportReflection->production_dis = $request->production_dis;
        $ReportReflection->shipment_dis = $request->shipment_dis;
        $ReportReflection->save();

        //примечания
        $ReportNotes = new ReportNotes;
        $ReportNotes->project_num = $project->projNum;
        $ReportNotes->projNotes = $request->projNotes;
        $ReportNotes->teamNotes = $request->teamNotes;
        $ReportNotes->resume = $request->resume;
        $ReportNotes->save();

        return redirect()->route('project-data-one', ['id' => $id]);
    }


    // РЕДАКТИРОВАНИЕ данных для отчета
    public function updateMessageSubmit($id, Request $req)
    {
        // Обновление отчет
        $project = Projects::find($id);

        // общая информация
        $Report = Report::where('project_num', $project->projNum)->first();
        // $Report = new Report;
        $Report->project_num = $project->projNum;
        $Report->costRubW = $req->costRubW;
        $Report->costRub = $req->costRub;
        $Report->expenseDirectPlan = $req->expenseDirectPlan;
        $Report->expenseDirectFact = $req->expenseDirectFact;
        $Report->expenseMaterialPlan = $req->expenseMaterialPlan;
        $Report->expenseMaterialFact = $req->expenseMaterialFact;
        $Report->expenseDeliveryPlan = $req->expenseDeliveryPlan;
        $Report->expenseDeliveryFact = $req->expenseDeliveryFact;
        $Report->expenseWorkPlan = $req->expenseWorkPlan;
        $Report->expenseWorkFact = $req->expenseWorkFact;
        $Report->expenseOtherPlan = $req->expenseOtherPlan;
        $Report->expenseOtherFact = $req->expenseOtherFact;
        $Report->expenseOpoxPlan = $req->expenseOpoxPlan;
        $Report->expenseOpoxFact = $req->expenseOpoxFact;
        $Report->marginProfitPlan = $req->marginProfitPlan;
        $Report->marginProfitFact = $req->marginProfitFact;
        $Report->marginalityPlan = $req->marginalityPlan;
        $Report->marginalityFact = $req->marginalityFact;
        $Report->profitPlan = $req->profitPlan;
        $Report->profitFact = $req->profitFact;
        $Report->projProfitPlan = $req->projProfitPlan;
        $Report->projProfitFact = $req->projProfitFact;
        $Report->save();

        // команда проекта
        if ($req->has('roles')) {
            foreach ($req->input('roles') as $index => $rolesData) {
                $teamMember = [
                    'roleFio' => $rolesData['roleFio'],
                    'roleDescription' => $rolesData['roleDescription'],
                    'roleImpact' => $rolesData['roleImpact'],
                    'roleBonus' => $rolesData['roleBonus'],
                    'premium_part' => $rolesData['premiumPart'],
                ];
    
                $existingRole = $project->report_team()->find($rolesData['roleId']);
    
                if ($existingRole) {
                    $existingRole->update($teamMember);
                } else {
                    $project->report_team()->create($teamMember);
                }
            }
        }

        //Рефлексия по проекту
        $ReportReflection = ReportReflection::where('project_num', $project->projNum)->first();
        $ReportReflection->project_num = $project->projNum;
        $ReportReflection->devRKD_adv = $req->devRKD_adv;
        $ReportReflection->complection_adv = $req->complection_adv;
        $ReportReflection->production_adv = $req->production_adv;
        $ReportReflection->shipment_adv = $req->shipment_adv;
        $ReportReflection->devRKD_dis = $req->devRKD_dis;
        $ReportReflection->complection_dis = $req->complection_dis;
        $ReportReflection->production_dis = $req->production_dis;
        $ReportReflection->shipment_dis = $req->shipment_dis;
        $ReportReflection->save();

        //примечания
        $ReportNotes = ReportNotes::where('project_num', $project->projNum)->first();
        // $ReportNotes = new ReportNotes;
        $ReportNotes->project_num = $project->projNum;
        $ReportNotes->projNotes = $req->projNotes;
        $ReportNotes->teamNotes = $req->teamNotes;
        $ReportNotes->resume = $req->resume;
        $ReportNotes->save();

        return redirect()->route('project-data-one', ['id' => $id, 'tab' => 'report'])->with('success', 'Changes successfully updated');
    }


    // удаление отчета 
    public function deleteMessage($id)
    {
        $project = Projects::find($id);
    
        if (!$project) {
            return abort(404); 
        }
    
        $project->reports()->delete();
        $project->report_notes()->delete();
        $project->report_reflection()->delete();
        $project->report_team()->delete();
    
        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#report'])->with('success', 'Project data successfully updated');
    }


    //сохранение в word
    public function exportWord($id, $projNum)
    {
        // Загружаем данные из базы данных
        $project = Projects::find($id);
        $projNumProject = Projects::find($projNum);

        // Путь к шаблону Word
        $templatePath = storage_path("report_template.docx");

        // Создаем новый TemplateProcessor и загружаем шаблон
        $templateProcessor = new TemplateProcessor($templatePath);
        // Получение данных из базы данных
        $teamMembers = DB::table('report_team')->where('project_num', $projNum)->get();

        // Определеяем количество строк для шаблона
        $templateProcessor->cloneRow('roleFio', count($teamMembers));

        // Обход каждой строки данных и добавление значений в соответствующие ячейки
        foreach ($teamMembers as $index => $teamMember) {
            $templateProcessor->setValue('roleFio#' . ($index + 1), $teamMember->roleFio);
            $templateProcessor->setValue('roleDescription#' . ($index + 1), $teamMember->roleDescription);
            $templateProcessor->setValue('roleImpact#' . ($index + 1), $teamMember->roleImpact);
            $templateProcessor->setValue('roleBonus#' . ($index + 1), $teamMember->roleBonus);
        }

        // Вставка значений в шаблон

        $templateProcessor->setValue('premium_part', $project->report_team->first()->premium_part);
        $templateProcessor->setValue('teamNotes', $project->report_notes->first()->teamNotes);

        $templateProcessor->setValue('projName', $project->basicReference->first()->projName);
        $templateProcessor->setValue('projNum', $project->projNum);
        $templateProcessor->setValue('projContractor', $project->contractor);
        $templateProcessor->setValue('costRubW', $project->reports->first()->costRubW);
        $templateProcessor->setValue('costRub', $project->reports->first()->costRub);
        $templateProcessor->setValue('expenseDirectPlan', $project->reports->first()->expenseDirectPlan);
        $templateProcessor->setValue('expenseDirectFact', $project->reports->first()->expenseDirectFact);
        $templateProcessor->setValue('expenseMaterialPlan', $project->reports->first()->expenseMaterialPlan);
        $templateProcessor->setValue('expenseMaterialFact', $project->reports->first()->expenseMaterialFact);
        $templateProcessor->setValue('expenseDeliveryPlan', $project->reports->first()->expenseDeliveryPlan);
        $templateProcessor->setValue('expenseDeliveryFact', $project->reports->first()->expenseDeliveryFact);
        $templateProcessor->setValue('expenseWorkPlan', $project->reports->first()->expenseWorkPlan);
        $templateProcessor->setValue('expenseWorkFact', $project->reports->first()->expenseWorkFact);
        $templateProcessor->setValue('expenseOtherPlan', $project->reports->first()->expenseOtherPlan);
        $templateProcessor->setValue('expenseOtherFact', $project->reports->first()->expenseOtherFact);
        $templateProcessor->setValue('expenseOpoxPlan', $project->reports->first()->expenseOpoxPlan);
        $templateProcessor->setValue('expenseOpoxFact', $project->reports->first()->expenseOpoxFact);
        $templateProcessor->setValue('marginProfitPlan', $project->reports->first()->marginProfitPlan);
        $templateProcessor->setValue('marginProfitFact', $project->reports->first()->marginProfitFact);
        $templateProcessor->setValue('marginalityPlan', $project->reports->first()->marginalityPlan);
        $templateProcessor->setValue('marginalityFact', $project->reports->first()->marginalityFact);
        $templateProcessor->setValue('profitPlan', $project->reports->first()->profitPlan);
        $templateProcessor->setValue('profitFact', $project->reports->first()->profitFact);
        $templateProcessor->setValue('projProfitPlan', $project->reports->first()->projProfitPlan);
        $templateProcessor->setValue('projProfitFact', $project->reports->first()->projProfitFact);
        $templateProcessor->setValue('projNotes', $project->report_notes->first()->projNotes);
        $templateProcessor->setValue('projManager', $project->projManager);

        $templateProcessor->setValue('devRKD_adv', $project->report_reflection->first()->devRKD_adv);
        $templateProcessor->setValue('complection_adv', $project->report_reflection->first()->complection_adv);
        $templateProcessor->setValue('production_adv', $project->report_reflection->first()->production_adv);
        $templateProcessor->setValue('shipment_adv', $project->report_reflection->first()->shipment_adv);
        $templateProcessor->setValue('devRKD_dis', $project->report_reflection->first()->devRKD_dis);
        $templateProcessor->setValue('complection_dis', $project->report_reflection->first()->complection_dis);
        $templateProcessor->setValue('production_dis', $project->report_reflection->first()->production_dis);
        $templateProcessor->setValue('shipment_dis', $project->report_reflection->first()->shipment_dis);
        $templateProcessor->setValue('resume', $project->report_notes->first()->resume);

        // Сохраняем измененный файл
        $newFilePath = storage_path("reports/отчет {$projNumProject->projNum}.docx");
        $templateProcessor->saveAs($newFilePath);

        // Возврат файла для загрузки
        return response()->download($newFilePath)->deleteFileAfterSend();
    }
}
