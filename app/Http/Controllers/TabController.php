<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\baseRisks;
use App\Models\Note;
use App\Models\Report;

class TabController extends Controller
{
    public function show($tab)
    {
        $project = Projects::find(1); 
    
        if (view()->exists("tables.{$tab}-projectMap")) {
            $additionalData = [];
    
            switch ($tab) {
                case 'risks':
                    $additionalData['baseRisks'] = baseRisks::all(); 
                    break;
    
                case 'notes':
                    $additionalData['notes'] = Note::all(); 
                    break;

                case 'reports':
                    $additionalData['reports'] = Report::all(); 
                     break;
    
                default:
            }
    
            $data = [
                'project' => $project,
                'tab' => $tab,
            ];
    
            $data = array_merge($data, $additionalData);
    
            $content = view("tables.{$tab}-projectMap", $data)->render();
    
            return response()->json(['content' => $content]);
        }
    
        return response()->json(['error' => 'Tab not found'], 404);
    }
}