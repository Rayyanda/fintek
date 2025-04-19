<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    //
    protected $table = "students";
    protected $fillable = [
        'student_id',
        'user_id',
        'nim',
        'fakultas',
        'prodi',
        'alamat',
        'semester',
        'ipk',
        'no_telp',
        'jenis_kelas',
        'pekerjaan',
        'alamat_kantor',
        'profile',
        'nama_wali',
        'telp_wali',
        'alamat_rumah',
        'pekerjaan_wali',
        'jabatan',
        'alamat_kantor_wali'
    ];

    //relasi one-to-one ke user
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    //relasi one-to-many ke tagihan
    public function tagihan():HasMany
    {
        return $this->hasMany(Tagihan::class,'student_id','student_id');
    }

    public function pencicilan()
    {
        return $this->hasMany(PenundaanTagihan::class,'student_id','student_id');
    }
    // Student.php
public function penundaanLangsung()
{
    return $this->hasManyThrough(
        Pencicilan::class,
        PenundaanTagihan::class,
        'student_id', // Foreign key di Tagihan
        'id',         // Local key di Penundaan
        'student_id', // Local key di Student
        'tagihan_id'  // Foreign key di Penundaan (jika one-to-one)
    );
}

}
