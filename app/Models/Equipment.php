<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'nameTMC',
        'manufacture',
        'unit',
        'count',
        'priceUnit',
        'price',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }
}
