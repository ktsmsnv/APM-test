<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportReflection extends Model
{
    protected $table = 'report_reflection';
    use HasFactory;
    protected $fillable = [
        'devRKD_adv',
        'complection_adv',
        'production_adv',
        'shipment_adv',
        'devRKD_dis',
        'complection_dis',
        'production_dis',
        'shipment_dis',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_num', 'projNum');
    }

}
