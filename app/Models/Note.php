<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function project() {
        return $this->belongsTo(Project::class);
    }
    protected $fillable = ['comment', 'date'];
}
