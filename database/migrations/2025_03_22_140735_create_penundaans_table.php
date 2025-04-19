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
        Schema::create('penundaans', function (Blueprint $table) {
            $table->id();
            //$table->foreignUuid('tagihan_id')->constrained('tagihans','tagihan_id')->onDelete('cascade');
            //$table->foreignUuid('student_id')->constrained('students','student_id')->cascadeOnDelete();
            $table->enum('opsi_penundaan',['1','2']);
            $table->string('jenis_tagihan');
            $table->integer('jumlah_tunggakan');
            $table->text('alasan');
            $table->string('tahun_ajaran');
            $table->enum('semester',['Ganjil','Genap']);
            $table->foreignId('status_id')->constrained('statuses','id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penundaans');
    }
};
