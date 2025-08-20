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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');             // Nama pegawai
            $table->string('jabatan');          // Jabatan / posisi
            $table->string('telepon')->nullable(); // Nomor telepon
            $table->text('alamat')->nullable();    // Alamat lengkap
            $table->date('tanggal_lahir')->nullable();     // Tanggal lahir
            $table->string('jenis_kelamin')->nullable();  // L / P
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
