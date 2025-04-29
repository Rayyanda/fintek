<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rkat extends Model
{
    //
    protected $table = 'rkats';
    protected $fillable = ['rkat_id', 'tahun_anggaran', 'nama_rkat', 'anggaran_tercairkan', 'anggaran_terpakai','status'];

    public function detail()
    {
        return $this->hasMany(DetailRkat::class,'rkat_id','rkat_id');
    }
}
