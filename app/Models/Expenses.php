<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'commandir',
        'rd',
        'shmr',
        'pnr',
        'cert',
        'delivery',
        'rastam',
        'ppo',
        'guarantee',
        'check',
        'total',
        'additional_expenses',
    ];

    public function total()
    {
        return $this->belongsTo(Total::class);
    }

    public function additionalExpenses()
    {
        return $this->hasMany(AdditionalExpense::class, 'expense_id');
    }
}
