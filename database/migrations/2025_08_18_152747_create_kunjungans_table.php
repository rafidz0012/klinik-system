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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade'); // relasi ke tabel pasien
            $table->date('tanggal_kunjungan');   // tanggal kunjungan
            $table->string('tipe_kunjungan');    // misal: Umum, Laboratorium, Gigi, dll
            $table->string('status')->default('pending'); // pending, selesai, dibatalkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
