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
        Schema::create('rkats', function (Blueprint $table) {
            $table->id();
            $table->uuid('rkat_id')->unique();
            $table->year('tahun_anggaran');
            $table->string('nama_rkat')->nullable();
            $table->integer('anggaran_tercairkan');
            $table->integer('anggaran_terpakai')->default(0);
            $table->enum('status',[1,2]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkats');
    }
};
