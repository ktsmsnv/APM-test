<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmkSub extends Model
{
    protected $table = 'smk_sub';

    public function main()
    {
        return $this->belongsTo(SmkMain::class, 'smk_main_id');
    }
}
