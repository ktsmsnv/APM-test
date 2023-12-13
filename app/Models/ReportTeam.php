<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTeam extends Model
{
    protected $table = 'report_team';

    use HasFactory;
    protected $fillable = [
        'roleFio',
        'roleDescription',
        'roleImpact',
        'roleBonus',
        'premium_part'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_num', 'projNum');
    }
}
