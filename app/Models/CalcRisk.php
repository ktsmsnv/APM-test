<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcRisk extends Model
{
    protected $table = 'calc_risks';
    protected $fillable = ['project_num', 'calcRisk_name'];
    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }

}
