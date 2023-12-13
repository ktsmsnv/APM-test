<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicReference extends Model
{
    protected $table = 'basic_reference';
    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }

}
