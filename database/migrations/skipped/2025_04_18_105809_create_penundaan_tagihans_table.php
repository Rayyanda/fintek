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
        Schema::create('penundaan_tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penundaan_id')->constrained('penundaans','id')->onDelete('cascade');
            $table->foreignUuid('tagihan_id')->constrained('tagihans','tagihan_id')->onDelete('cascade');
            $table->foreignUuid('student_id')->constrained('students','student_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penundaan_tagihans');
    }
};
