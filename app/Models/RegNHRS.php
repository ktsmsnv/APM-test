<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegNHRS extends Model
{
    use HasFactory;
    protected $table = 'registry_nhrs';
    protected $fillable = [
        'vnNum',
        'purchaseName',
        'delivery',
        'pir',
        'kd',
        'prod',
        'shmr',
        'pnr',
        'po',
        'smr',
        'purchaseOrg',
        'endUser',
        'object',
        'receiptDate',
        'submissionDate',
        'projectManager',
        // 
    ];
}
