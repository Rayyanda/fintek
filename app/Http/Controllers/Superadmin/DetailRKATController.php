<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DetailRkat;
use App\Models\Rkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DetailRKATController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rkat_id' => "required|exists:rkats,rkat_id",
            'tanggal'=> 'required|date',
            'harga'=> 'required|integer',
            'peruntukkan'=>'required',
            'jumlah'=>'required',
            'satuan'=>'required',
            'bukti_penggunaan'=>'required|image|mimes:png,jpg,jpeg|max:2048',
            'status'=>'required',
            'keterangan'=>'nullable',
        ]);

        $bukti = $request->file('bukti_penggunaan');

        $rkat = Rkat::where('rkat_id','=',$request->rkat_id)->first();

        $bukti->storeAs('public/images/keuangan/rkat/'. $rkat->tahun_anggaran, $bukti->hashName());

        $total = $request->harga * $request->jumlah;

        DetailRkat::create([
            'detail_id'=> Str::uuid(),
            'rkat_id' => $validated['rkat_id'],
            'tanggal' => $validated['tanggal'],
            'harga' => $validated['harga'],
            'peruntukkan' => $validated['peruntukkan'],
            'jumlah' => $validated['jumlah'],
            'satuan' => $validated['satuan'],
            'total' => $total,
            'bukti_penggunaan' => $bukti->hashName(),
            'status'=> $validated['status'],
            'keterangan' => $validated['keterangan'],
        ]);

        $rkat->update([
            'anggaran_terpakai' => $rkat->anggaran_terpakai + $total
        ]);

        return redirect()->route('superadmin.rkat.show',$request->rkat_id)->with('success','Berhasil menambahkan');
    }
}
