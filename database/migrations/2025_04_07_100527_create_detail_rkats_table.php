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
        Schema::create('detail_rkats', function (Blueprint $table) {
            $table->id();
            $table->uuid('detail_id')->unique();
            $table->foreignUuid('rkat_id')->references('rkat_id')->on('rkats')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->string('peruntukkan');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->integer('total');
            $table->string('bukti_penggunaan');
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_rkats');
    }
};
