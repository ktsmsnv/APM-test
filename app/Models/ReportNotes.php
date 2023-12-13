<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNotes extends Model
{
    protected $table = 'report_notes';
    use HasFactory;
    protected $fillable = [
        'projNotes',
        'teamNotes',
        'resume',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_num', 'projNum');
    }

}
