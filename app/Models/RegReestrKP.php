<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegReestrKP extends Model
{
    use HasFactory;
    protected $table = 'registry_reestrKP';
    protected $fillable = ['numIncoming', 'date', 'orgName', 'whom', 'sender', 'amountNDS', 'purchNum', 'note', 'word_file', 'original_word_file_name']; // Добавляем 'original_word_file_name'

    // Здесь можно добавить связь с дополнительными файлами, если необходимо
    public function additionalFiles()
    {
        return $this->hasMany(AdditionalFile::class, 'kp_id');
    }
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_num', 'projNum');
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
