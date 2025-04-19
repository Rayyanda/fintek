<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    //
    protected $table = 'tagihans';
    protected $fillable = [
        'tagihan_id',
        'student_id',
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

    public function penundaant()
    {
        return $this->belongsTo(PenundaanTagihan::class,'tagihan_id', 'tagihan_id');
    }

    public function penundaans()
    {
        return $this->belongsToMany(Penundaan::class,'penundaan_tagihans','tagihan_id','penundaan_id');
    }
}
