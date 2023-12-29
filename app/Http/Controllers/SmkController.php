<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\SmkMain;
use App\Models\SmkSub;

class SmkController extends Controller
{
    // переход на страницу создание реализации
    public function create()
    {
        return view('add-smk');
    }

    // Отображение данных из расчета
    public function showDataSMK($id)
    {
        $project = Projects::with('smk_main', 'smk_main.subs')->find($id);
        return view('add-smk', compact('project'));
    }

    // сохранение данных
    public function storeNew($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);
    
        // базовая справка
        $SmkMain = new SmkMain;
        $SmkMain->project_num = $project->projNum;
        $SmkMain->project_quality_desc = $request->project_quality_desc;
        $SmkMain->project_quality_fi = $request->project_quality_fi;
        $SmkMain->project_quality_ki = $request->project_quality_ki;
        $SmkMain->save();
    
        // доп информация
        $SmkSub = new SmkSub;
        $SmkSub->smk_main_id = $SmkMain->id;
        $SmkSub->num = $request->num;
        $SmkSub->cost = $request->cost;
        $SmkSub->period = $request->period;
        $SmkSub->quality = $request->quality;
        $SmkSub->save();
    
        return redirect()->route('project-data-one', $id)->with('success');
    }
}
