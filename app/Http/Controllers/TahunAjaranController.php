<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    //
    public function index()
    {
        $data = TahunAjaran::all();
        return view('tahun-ajaran.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required',
        ]);

        $cek = TahunAjaran::where('tahun_ajaran','=',$request->tahun_ajaran)
            ->where('semester','=',$request->semester)->first();

        if($cek)
        {
            return redirect()->back()->with('error','Data sudah Ada');
        }

        TahunAjaran::create($validated);

        return redirect()->back()->with('success','Berhasil menambahkan data');

    }

    public function destroy($id)
    {
        $dt = TahunAjaran::find($id);
        $dt->delete();
        return redirect()->back()->with('success','Berhasil menghapus data');
    }

    public function update(Request $request, $id)
    {

        TahunAjaran::query()->update(['is_active'=>false]);
        $dt = TahunAjaran::find($id);
        $dt->update([
            'is_active' => true
        ]);
        return redirect()->back()->with('success','Berhasil mengupdate data');
    }
}
