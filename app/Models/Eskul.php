<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    protected $table = "eskul";

    protected $fillable = [
        'cabang_eskul',
        'hari',
        'waktu',
        'tempat',
    ];
}
