<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenundaanTagihan extends Model
{
    //
    protected $table = 'penundaan_tagihans';
    protected $fillable = [
        'tagihan_id',
        'penundaan_id',
        'student_id',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class,'tagihan_id','tagihan_id');
    }

    public function penundaan()
    {
        return $this->belongsTo(Penundaan::class,'penundaan_id','id');
    }

    public function pencicilan()
    {
        return $this->hasMany(Pencicilan::class,'penundaan_id','penundaan_id')->distinct();
    }

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }
}
