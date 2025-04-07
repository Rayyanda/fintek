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
        Schema::create('pencicilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penundaan_id')->constrained('penundaans','id')->onDelete('cascade');
            $table->date('tgl_jatuh_tempo');
            $table->integer('cicilan');
            $table->enum('status',['Belum Lunas','Lunas']);
            $table->date('tgl_pembayaran')->nullable();
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencicilans');
    }
};
