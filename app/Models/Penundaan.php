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
        'student_id',
        'opsi_penundaan',
        'jumlah_tunggakan',
        'alasan',
        'tahun_ajaran',
        'semester',
        'status_id'
    ];

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function status():HasOne
    {
        return $this->hasOne(Status::class,'id','status_id');
    }

    public function cicilan():HasMany
    {
        return $this->hasMany(Pencicilan::class,'penundaan_id','id');
    }
}
