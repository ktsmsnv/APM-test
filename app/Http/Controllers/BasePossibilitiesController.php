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

    public function getBasePossibility($id)
    {
        $basePossibilities = basePossibilities::find($id);
        return response()->json($basePossibilities);
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
        $itemId = $request->input('editItemId_possib');

        $basePossibilities = BasePossibilities::find($itemId);

        if (!$basePossibilities) {
            abort(404, 'BasePossibilities not found');
        }
        $basePossibilities->nameRisk = $request->input('nameRisk_possib_edit');

        $reasonRiskData = $request->input('reason_possib_edit');
        $basePossibilities->reasonRisk = json_encode(array_map(fn ($reason) => ['reasonRisk_possib' => $reason], $reasonRiskData));

        $conseqRiskData = $request->input('conseq_possib_edit');
        $basePossibilities->conseqRiskOnset = json_encode(array_map(fn ($conseq) => ['conseqRiskOnset_possib' => $conseq], $conseqRiskData));

        $counteringRiskData = $request->input('countering_possib_edit');
        $basePossibilities->counteringRisk = json_encode(array_map(fn ($countering) => ['counteringRisk_possib' => $countering], $counteringRiskData));

        $measuresRiskData = $request->input('measures_possib_edit');
        $basePossibilities->riskManagMeasures = json_encode(array_map(fn ($measures) => ['riskManagMeasures_possib' => $measures], $measuresRiskData));

        $basePossibilities->term = $request->input('term_possib_edit');

        $basePossibilities->save();

        return redirect()->route('baseRisks');
    }
}
