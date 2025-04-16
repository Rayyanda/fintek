<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    //
    protected $table = 'tagihans';
    protected $fillable = [
        'tagihan_id',
        'studen_id',
        'tahun_ajaran',
        'semester',
        'jenis_tagihan',
        'nominal',
        'denda',
        'potongan',
        'total',
        'terbayar',
        'sisa',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function penundaan()
    {
        return $this->hasOne(Penundaan::class,'tagihan_id','tagihan_id');
    }
}
