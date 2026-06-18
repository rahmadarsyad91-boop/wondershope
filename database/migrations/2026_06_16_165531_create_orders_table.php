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
    // FIX: Gunakan Schema, bukan Route
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('nama_penerima');
        $table->string('telepon');
        $table->text('alamat_lengkap');
        $table->string('metode_bayar');
        $table->integer('total_harga');
        $table->string('status')->default('Pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
