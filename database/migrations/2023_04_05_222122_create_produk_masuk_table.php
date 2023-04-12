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
        Schema::create('produk_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('produk_id');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->date('tangal_masuk');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_masuk');
    }
};
