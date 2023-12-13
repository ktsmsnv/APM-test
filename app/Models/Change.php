<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $fillable = [
        'project_num',
        'contractor',
        'contract_num',
        'change',
        'impact',
        'stage',
        'corrective',
        'responsible',
    ];

    protected $table = 'changes';
        public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }
}
