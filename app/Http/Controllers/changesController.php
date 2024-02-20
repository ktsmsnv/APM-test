<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Change;
use App\Models\BasicInfo;

class changesController extends Controller
{
    // переход на страницу создание реализации
    public function create()
    {
        return view('add-changes');
    }

    // Отображение данных из расчета
    public function showDataCalculation($id)
    {
        $project = Projects::with('basicInfo')->find($id);
        return view('add-changes', compact('project'));
    }

    // сохранение данных
    public function storeNew($id, Request $request)
    {
        // поиск связанной карты проекта
        $project = Projects::find($id);

        if ($request->has('changes')) {
            $data_changes = array();
            foreach ($request->input('changes') as $index => $ChangesData) {
                $item = array(
                    'project_num' => $project->projNum,
                    'project' => $project->projNum,
                    'contractor' => $ChangesData['contractor'],
                    'contract_num' => $ChangesData['contract_num'],
                    'change' => $ChangesData['change'],
                    'impact' => $ChangesData['impact'],
                    'stage' => $ChangesData['stage'],
                    'corrective' => $ChangesData['corrective'],
                    'responsible' => $ChangesData['responsible']
                );
                array_push($data_changes, $item);
            }
            Change::insert($data_changes);
        }
        return redirect()->route('project-data-one', ['id' => $id, 'tab' => '#changes'])->with('success', 'Project data successfully updated');
    }


    public function delete($id)
    {
        $change = Change::find($id);

        if (!$change) {
            return response()->json(['message' => 'Change record not found'], 404);
        }

        $projectId = $change->project_id; 

        $change->delete();

        return response()->json(['projectId' => $projectId]);
    }


    public function update(Request $request, $id)
    {
        // Находим объект изменения по его идентификатору
        $change = Change::find($id);
        
        // Проверяем, найден ли объект изменения
        if ($change) {
            // Обновляем атрибуты изменения из запроса
            $change->update([
                'contractor' => $request->input('contractor'),
                'contract_num' => $request->input('contract_num'),
                'change' => $request->input('change'),
                'impact' => $request->input('impact'),
                'stage' => $request->input('stage'),
                'corrective' => $request->input('corrective'),
                'responsible' => $request->input('responsible'),
            ]);
            
            // Получаем объект проекта через отношение project
            $project = $change->project;
            
            // Проверяем, найден ли объект проекта
            if ($project) {
                // Получаем идентификатор проекта
                $projectId = $project->id;
                
                // Перенаправляем пользователя с обновленным идентификатором проекта
                return redirect()->route('project-data-one', ['id' => $projectId, 'tab' => '#changes'])->with('success', 'Project data successfully updated');
            }
        }
        
        // Если объект изменения не найден, возвращаем ошибку
        return redirect()->back()->with('error', 'Change not found.');
    }
}
