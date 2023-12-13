<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markup extends Model
{
    protected $fillable = [
        'project_num',
        'date',
        'percentage',
        'priceSubTkp',
        'agreedFio',
    ];
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
