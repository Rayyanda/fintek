<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pencicilan;
use App\Models\PerubahanCicilan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PerubahanCicilanController extends Controller
{
    //
    public function store(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|exists:pencicilans,id',
            'tgl_jatuh_tempo' => 'required|date',
            'cicilan' => 'required',
        ]);

        $cicilan = Pencicilan::where('id','=',$request->id)->first();

        $tanggalBaru = Carbon::parse($request->tgl_jatuh_tempo);
        $tanggalLama = Carbon::parse($cicilan->tgl_jatuh_tempo); // bisa dari DB juga

        if ($tanggalBaru->month !== $tanggalLama->month || $tanggalBaru->year !== $tanggalLama->year) {
            return back()->withErrors(['tgl_jatuh_tempo' => 'Bulan dan tahun tidak boleh diubah.']);
        }

        PerubahanCicilan::create([
            'cicilan_id' => $request->id,
            'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            'cicilan' => $request->cicilan,
            'status' => 'Diajukan'
        ]);

        return redirect()->route('mhs.penundaan.index')->with('success','Berhail membuat ajuan.');

    }

    public function destroy($id)
    {
        PerubahanCicilan::where('id','=',$id)->delete();
        return redirect()->route('mhs.penundaan.index')->with('success','Berhasil membatalkan ajuan');
    }
}
