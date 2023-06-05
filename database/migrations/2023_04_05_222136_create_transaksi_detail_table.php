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
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onUpdate('cascade')->onDelete('cascade');
            $table->string('produk_id')->nullable();
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->integer('jumlah');
            $table->unsignedBigInteger('total_harga');
            $table->string('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
