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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('student_id')->unique();
            $table->foreignUuid('user_id')->constrained('users','user_id')->cascadeOnDelete();
            $table->string('nim')->unique();
            $table->string('fakultas')->default('Teknik');
            $table->string('prodi');
            $table->text('alamat');
            $table->integer('semester');
            $table->double('ipk');
            $table->string('no_telp');
            $table->enum('jenis_kelas',['Pagi','Malam']);
            $table->string('pekerjaan')->default('Mahasiswa');
            $table->text('alamat_kantor')->nullable();
            $table->string('profile')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('telp_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('alamat_kantor_wali')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
