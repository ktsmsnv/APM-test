<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegSInteg;
use App\Models\RegEOB;
use App\Models\RegNHRS;
use App\Models\RegOther;

class DataController extends Controller
{
    public function index()
    {
        $RegSInteg = RegSInteg::all();
        $RegEOB = RegEOB::all();
        $RegNHRS = RegNHRS::all();
        $RegOther = RegOther::all();

        return view('home', compact('RegSInteg', 'RegEOB', 'RegNHRS', 'RegOther'));
    }

    public function getData_group_1()
    {
        $RegSInteg = RegSInteg::all();

        // Возвращаем данные в формате JSON
        return response()->json($RegSInteg);
    }
}
