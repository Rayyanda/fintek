<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pencicilan extends Model
{
    //
    protected $table = 'pencicilans';
    protected $fillable = [
        'penundaan_id',
        'tgl_jatuh_tempo',
        'cicilan',
        'status',
        'tgl_pembayaran',
        'bukti'
    ];

    public function penundaan()
    {
        return $this->belongsTo(Penundaan::class, 'penundaan_id', 'id');
    }

    public function perubahan()
    {
        return $this->hasOne(PerubahanCicilan::class,'cicilan_id','id');
    }
}
