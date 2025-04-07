<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerubahanCicilan extends Model
{
    //
    protected $table = 'perubahan_cicilans';
    protected $fillable = [
        'cicilan_id',
        'tgl_jatuh_tempo',
        'cicilan',
        'status'
    ];

    //relasi ke tabel pencicilan
    public function cicilan()
    {
        return $this->belongsTo(Pencicilan::class,'id','cicilan_id');
    }

}
