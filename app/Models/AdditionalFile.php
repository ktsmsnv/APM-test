<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFile extends Model
{
    use HasFactory;

    protected $fillable = ['kp_id', 'original_file_name', 'file_name', 'file_content']; // Добавляем 'original_file_name'

    // Здесь можно добавить связь с родительским КП, если необходимо
    public function reestrKP()
    {
        return $this->belongsTo(RegReestrKP::class, 'kp_id');
    }
}