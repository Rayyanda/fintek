<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    //
    protected $table = 'inventaris';
    protected $fillable = [
        'nama_barang',
        'jumlah_barang',
        'lokasi',
        'status',
        'keterangan'
    ];
}
