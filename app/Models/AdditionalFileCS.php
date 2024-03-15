<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFileCS extends Model
{
    use HasFactory;
    protected $table = 'additional_files_contractStorage';
    protected $fillable = ['cs_id', 'original_file_name_cs', 'file_name_cs', 'file_content_cs']; // Добавляем 'original_file_name'

    // Здесь можно добавить связь с родительским КП, если необходимо
    public function contractStorage()
    {
        return $this->belongsTo(ContractStorage::class, 'cs_id');
    }
}
