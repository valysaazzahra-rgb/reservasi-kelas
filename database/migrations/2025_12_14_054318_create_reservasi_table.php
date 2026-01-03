<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('reservasi', function (Blueprint $table) {
        $table->id();
        $table->string('nim');
        $table->string('nama_mahasiswa');
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        $table->date('tanggal');
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->text('tujuan_peminjaman');
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
