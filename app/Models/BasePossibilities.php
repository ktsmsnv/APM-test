<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basePossibilities extends Model
{
    use HasFactory;
    protected $table = 'base_possibilities';
    protected $casts = [
        'reasonRisk' => 'json',
        'conseqRiskOnset' => 'json',
        'counteringRisk' => 'json',
        'riskManagMeasures' => 'json',
    ];
    protected $fillable = ['nameRisk', 'reasonRisk', 'conseqRiskOnset', 'counteringRisk', 'term', 'riskManagMeasures'];
    
}
