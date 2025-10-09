<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    protected $table = "eskul";

    protected $fillable = [
        'cabang-eskul',
        'hari_1',
        'hari_2',
        'hari_4',
    ];
}
