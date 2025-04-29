<?php

namespace App\Http\Controllers;

use App\Models\Rkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RKATController extends Controller
{
    //
    public function index()
    {
        $rkat = Rkat::with(['detail'])->orderBy('tahun_anggaran','desc')->paginate(10);
        return view('rkat.index', ['rkats'=>$rkat]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rkat' => 'nullable',
            'tahun_anggaran'=>'required',
            'anggaran_tercairkan'=>'required|integer'
        ]);

        Rkat::create([
            'rkat_id'=> Str::uuid(),
            'nama_rkat' => $validated['nama_rkat'],
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'anggaran_tercairkan' => $validated['anggaran_tercairkan'],
            'status' => 1
        ]);

        return redirect()->route('superadmin.rkat.index')->with('success','Berhasil menambahkan');
    }

    public function show($rkat_id)
    {
        $rkat = Rkat::where('rkat_id','=',$rkat_id)->with(['detail'])->first();
        return view('rkat.show', ['rkat'=>$rkat]);
    }
}
