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
        Schema::create('tindakans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();          // Kode tindakan
            $table->string('nama');                     // Nama tindakan
            $table->text('deskripsi')->nullable();     // Deskripsi tindakan
            $table->decimal('harga', 15, 2)->default(0); // Harga tindakan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindakans');
    }
};
