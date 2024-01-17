<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegOther extends Model
{
    use HasFactory;
    protected $table = 'registry_other';
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
