<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRkat extends Model
{
    //
    protected $table = 'detail_rkats';
    protected $fillable = [
        'detail_id',
        'rkat_id',
        'tanggal',
        'peruntukkan',
        'harga',
        'jumlah',
        'satuan',
        'total',
        'bukti_penggunaan',
        'status',
        'keterangan'
    ];

    public function rkat()
    {
        return $this->belongsTo(Rkat::class,'rkat_id','rkat_id');
    }
}
