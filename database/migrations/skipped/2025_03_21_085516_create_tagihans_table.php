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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->uuid('tagihan_id')->unique();
            $table->foreignUuid('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->enum('semester',['Ganjil','Genap']);
            $table->string('jenis_tagihan');
            $table->integer('nominal');
            $table->integer('denda')->default(0);
            $table->integer('potongan')->default(0);
            $table->integer('total')->default(0);
            $table->integer('terbayar')->default(0);
            $table->integer('sisa')->default(0);
            $table->string('status')->default('Belum Divalidasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
