<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{
    protected $fillable = [
        'project_num',
        'fio',
        'post',
        'responsibility',
        'contact',
    ];
    public function project()
    {
        return $this->belongsTo(Projects::class,  'project_num', 'projNum');
    }
    public function markups()
    {
        return $this->belongsToMany(Markup::class, 'contact_markup', 'contact_id', 'markup_id');
    }
}
