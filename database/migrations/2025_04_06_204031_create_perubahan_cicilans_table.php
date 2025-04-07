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
        Schema::create('perubahan_cicilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cicilan_id')->constrained('pencicilans')->onDelete('cascade');
            $table->date('tgl_jatuh_tempo');
            $table->integer('cicilan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perubahan_cicilans');
    }
};
