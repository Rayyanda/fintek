<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    //
    public function index()
    {
        $inventaris = Inventaris::paginate(15);
        return view('inventaris.index',['inventaris'=>$inventaris]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'=>'required',
            'jumlah_barang'=>'required',
            'lokasi'=>'required',
            'keterangan'=>'nullable',
            'status'=> 'required'
        ]);

        Inventaris::create($validated);

        return redirect()->route('inventaris.index')->with('success','Berhasil menambahkan data');
    }

    public function destroy(Request $request)
    {
        $id = $request->id_inv;
        Inventaris::where('id','=',$id)->delete();
        return redirect()->route('inventaris.index')->with('success','Berhasil menghapus data');
    }
}
