<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStorage extends Model
{
    use HasFactory;
    protected $table = 'contract_storage';
    protected $fillable = ['contractName', 'contractor', 'dateStart', 'dateEnd', 'daysLeft']; // Добавляем 'original_word_file_name'

    public function additionalFilesCS()
    {
        return $this->hasMany(AdditionalFileCS::class, 'cs_id');
    }
    // Мутатор для формирования номера КП
    // public function setNumIncomingAttribute($value)
    // {
    //     $year = date('y');
    //     $lastKP = RegReestrKP::whereYear('created_at', date('Y'))->max('numIncoming');
    //     $lastKP = $lastKP ? explode('-', $lastKP)[1] : 0;
    //     $this->attributes['numIncoming'] = 'КП-' . ($lastKP + 1) . '/' . $year;
    // }
}
