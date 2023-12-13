<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    protected $fillable = [
        'periodDays',
        'price',
        'kdDays',
        'equipmentDays',
        'productionDays',
        'shipmentDays',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }
}
