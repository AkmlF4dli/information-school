<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";

    protected $fillable = [
        'id',
        'identity',
        'name',
        'kelas',
        'jurusan',
        'role',
        'mata_pelajaran',
        'jam_pelajaran',
        'tanggal_tugas',
        'alasan_izin',
        'input_by',
        'cabang_eskul',
        'created_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'name');
    }

}
