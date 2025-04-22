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

    //relasi one-to-many ke penundaan
    public function penundaan():HasMany
    {
        return $this->hasMany(Penundaan::class,'student_id','student_id')->latest();
    }

}
