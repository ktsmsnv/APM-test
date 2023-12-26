<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmkMain extends Model
{
    protected $table = 'smk_main';

    public function subs()
    {
        return $this->hasMany(SmkSub::class, 'smk_main_id');
    }
}
