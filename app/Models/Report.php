<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{    protected $table = 'reports';
    use HasFactory;
    protected $fillable = [
        'project_num',
        'costRubW',
        'costRub',
        'expenseDirectPlan',
        'expenseMaterialPlan',
        'expenseDeliveryPlan',
        'expenseWorkPlan',
        'expenseOtherPlan',
        'expenseOpoxPlan',
        'marginProfitPlan',
        'marginalityPlan',
        'profitPlan',
        'projProfitPlan',
        'expenseDirectFact',
        'expenseMaterialFact',
        'expenseDeliveryFact',
        'expenseWorkFact',
        'expenseOtherFact',
        'expenseOpoxFact',
        'marginProfitFact',
        'marginalityFact',
        'profitFact',
        'projProfitFact',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_num', 'projNum');
    }
}
