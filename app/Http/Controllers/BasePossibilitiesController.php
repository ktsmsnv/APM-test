<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\basePossibilities;
use Illuminate\Support\Facades\Log;

class BasePossibilitiesController extends Controller
{
    public function index()
    {
        $basePossibilities = basePossibilities::all();

        return view('base-risks', compact('basePossibilities'));
    }

    // сохранение полей в бд
    public function store(Request $request)
    {
        $basePossibilities = new basePossibilities;
        $basePossibilities->nameRisk = $request->input('nameRisk');
        $basePossibilities->reasonRisk = json_encode($request->input('reason_risk'));
        $basePossibilities->conseqRiskOnset = json_encode($request->input('conseq_risk'));
        $basePossibilities->counteringRisk = json_encode($request->input('countering_risk'));
        $basePossibilities->term = $request->input('term');
        $basePossibilities->riskManagMeasures = json_encode($request->input('measures_risk'));
        $basePossibilities->save();

        return redirect()->route('baseRisks');
    }

    public function delete($id)
    {
        $basePossibilities = basePossibilities::find($id);
        $basePossibilities->delete();
        return redirect()->route('baseRisks');
    }

    public function update(Request $request)
    {
        $itemId = $request->input('editItemId');
        $basePossibilities = basePossibilities::find($itemId);
    
        $basePossibilities->nameRisk = $request->input('nameRisk');
    
        // Парсим JSON-строку, если она не является массивом
        $reasonRiskData = $request->input('reason_risk_edit');
        $basePossibilities->reasonRisk = json_encode(array_map(fn($reason) => ['reasonRisk' => $reason], $reasonRiskData));
    
        $conseqRiskData = $request->input('conseq_risk_edit');
        $basePossibilities->conseqRiskOnset = json_encode(array_map(fn($conseq) => ['conseqRiskOnset' => $conseq], $conseqRiskData));
    
        $counteringRiskData = $request->input('countering_risk_edit');
        $basePossibilities->counteringRisk = json_encode(array_map(fn($countering) => ['counteringRisk' => $countering], $counteringRiskData));
    
        $measuresRiskData = $request->input('measures_risk_edit');
        $basePossibilities->riskManagMeasures = json_encode(array_map(fn($measures) => ['riskManagMeasures' => $measures], $measuresRiskData));
    
        $basePossibilities->term = $request->input('term');
    
        $basePossibilities->save();
    
        return redirect()->route('baseRisks');
    }

}
