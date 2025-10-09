<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('identity');
            $table->string('name');
            $table->string('kelas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('role');
            $table->string('mata_pelajaran')->nullable();
            $table->string('tanggal_tugas')->nullable();
            $table->integer('jam_pelajaran')->nullable();
            $table->string('alasan_izin')->nullable();
            $table->string('input_by')->nullable();
            $table->string('cabang_eskul')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
