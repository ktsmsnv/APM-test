<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\baseRisks;
use App\Models\Risks;

class risksController extends Controller
{

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


    public function store(Request $request, $projectId)
    {
        $project = Projects::find($projectId);

        if (!$project) {
            return response()->json(['error' => 'проект не найден'], 404);
        }

        // Получение данных из формы
        $risk = new Risks();

        $risk->risk_reason = json_encode($request->input('risk_reason'));
        $risk->risk_consequences = json_encode($request->input('risk_consequences'));
        $risk->risk_counteraction = json_encode($request->input('risk_counteraction'));
        $risk->risk_measures = json_encode($request->input('risk_measures'));


        $risk->risk_name = $request->input('risk_name');

        $risk->risk_probability = intval($request->input('risk_probability'));
        $risk->risk_influence = intval($request->input('risk_influence'));
        $risk->risk_estimate = $risk->risk_probability * $risk->risk_influence;
        $risk->risk_strategy = $risk->risk_estimate > 32 ? 'снижение' : ($risk->risk_estimate == 0 ? null : 'принятие');
        $risk->risk_term = $request->input('risk_term');
        $risk->risk_mark = $request->input('risk_mark');
        $risk->risk_responsible = $request->input('risk_resp');
        $risk->risk_endTerm = $request->input('risk_endTerm');

        // Сохранение риска и связь с проектом
        $project->risks()->save($risk);

        return redirect()->route('project-data-one', ['id' => $projectId]);
    }

    public function delete($id)
    {
        $risk = Risks::find($id);
        $projectId = $risk->project_id; 
        $risk->delete();
        return response()->json(['projectId' => $projectId]);
    }

    public function update(Request $request, $id) {
        $risk = Risks::find($id);
        if (!$risk) {
            return response()->json(['message' => 'Risk record not found'], 404);
        }
        $risk->risk_probability = intval($request->input('risk_probability'));
        $risk->risk_influence = intval($request->input('risk_influence'));

        $risk->risk_estimate = $risk->risk_probability * $risk->risk_influence;
        $risk->risk_strategy = $risk->risk_estimate > 32 ? 'снижение' : ($risk->risk_estimate == 0 ? null : 'принятие');

        $risk->risk_mark = $request->input('risk_mark');
        $risk->risk_responsible = $request->input('risk_responsible');
        $risk->risk_endTerm = $request->input('risk_endTerm');
    

        $risk->save();
        $projectId = $request->input('projectId');
    
        return redirect()->route('project-data-one', ['id' => $projectId]);
    }
}
