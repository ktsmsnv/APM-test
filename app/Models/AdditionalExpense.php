<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalExpense extends Model
{
    use HasFactory;
    protected $fillable = ['cost'];

    public function expense()
    {
        return $this->belongsTo(Expenses::class);
    }
}
