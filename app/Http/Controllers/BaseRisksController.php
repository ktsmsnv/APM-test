<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\baseRisks;
use Illuminate\Support\Facades\Log;

class BaseRisksController extends Controller
{
    public function index()
    {
        $baseRisks = baseRisks::all();

        return view('base-risks', compact('baseRisks'));
    }

    // сохранение полей в бд
    public function store(Request $request)
    {
        $baseRisks = new baseRisks;
        $baseRisks->nameRisk = $request->input('nameRisk');
        $baseRisks->reasonRisk = json_encode($request->input('reason_risk'));
        $baseRisks->conseqRiskOnset = json_encode($request->input('conseq_risk'));
        $baseRisks->counteringRisk = json_encode($request->input('countering_risk'));
        $baseRisks->term = $request->input('term');
        $baseRisks->riskManagMeasures = json_encode($request->input('measures_risk'));
        $baseRisks->save();

        return redirect()->route('baseRisks');
    }

    public function delete($id)
    {
        $baseRisks = baseRisks::find($id);
        $baseRisks->delete();
        return redirect()->route('baseRisks');
    }

    public function update(Request $request)
    {
        $itemId = $request->input('editItemId');
        $baseRisks = baseRisks::find($itemId);
    
        $baseRisks->nameRisk = $request->input('nameRisk');
    
        // Парсим JSON-строку, если она не является массивом
        $reasonRiskData = $request->input('reason_risk_edit');
        $baseRisks->reasonRisk = json_encode(array_map(fn($reason) => ['reasonRisk' => $reason], $reasonRiskData));
    
        $conseqRiskData = $request->input('conseq_risk_edit');
        $baseRisks->conseqRiskOnset = json_encode(array_map(fn($conseq) => ['conseqRiskOnset' => $conseq], $conseqRiskData));
    
        $counteringRiskData = $request->input('countering_risk_edit');
        $baseRisks->counteringRisk = json_encode(array_map(fn($countering) => ['counteringRisk' => $countering], $counteringRiskData));
    
        $measuresRiskData = $request->input('measures_risk_edit');
        $baseRisks->riskManagMeasures = json_encode(array_map(fn($measures) => ['riskManagMeasures' => $measures], $measuresRiskData));
    
        $baseRisks->term = $request->input('term');
    
        $baseRisks->save();
    
        return redirect()->route('baseRisks')->with('success', 'Record updated successfully');
    }

}
