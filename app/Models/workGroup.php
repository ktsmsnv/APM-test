<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workGroup extends Model
{ protected $table = 'workGroup';
    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }
}
