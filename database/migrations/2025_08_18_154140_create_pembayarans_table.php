<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade'); // relasi ke kunjungan
            $table->decimal('total', 15, 2)->default(0); // total pembayaran
            $table->string('status_bayar')->default('pending'); // pending, lunas
            $table->date('tanggal_bayar')->nullable(); // tanggal pembayaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
