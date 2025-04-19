<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penundaan extends Model
{
    //
    protected $table = 'penundaans';
    protected $fillable = [
        'opsi_penundaan',
        'jenis_tagihan',
        'jumlah_tunggakan',
        'alasan',
        'tahun_ajaran',
        'semester',
        'status_id'
    ];

    public function tagihans()
    {
        return $this->belongsToMany(Tagihan::class,'penundaan_tagihans','penundaan_id','tagihan_id','id');
    }

    public function getStudentAttribute()
    {
        return $this->tagihan->student;
    }

    // public function student():BelongsTo
    // {
    //     return $this->belongsTo(Student::class,'student_id','student_id');
    // }

    public function status():HasOne
    {
        return $this->hasOne(Status::class,'id','status_id');
    }

    public function cicilans():HasMany
    {
        return $this->hasMany(Pencicilan::class,'penundaan_id','id');
    }
    public function penundaans()
    {
        return $this->hasOne(PenundaanTagihan::class,'penundaan_id','id');
    }
}
