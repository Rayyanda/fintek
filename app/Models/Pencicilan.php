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
}
