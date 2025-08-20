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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                     // Nama pasien
            $table->text('alamat')->nullable();         // Alamat lengkap
            $table->string('telepon')->nullable();      // Nomor telepon
            $table->date('tanggal_lahir')->nullable();  // Tanggal lahir
            $table->string('jenis_kelamin')->nullable(); // L/P
            $table->string('no_identitas')->nullable();    // KTP/SIM/Passport
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
