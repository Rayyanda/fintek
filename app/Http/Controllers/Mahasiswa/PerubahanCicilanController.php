<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pencicilan;
use App\Models\PerubahanCicilan;
use App\Models\User;
use App\Notifications\PerubahanCicilanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $cek = PerubahanCicilan::where('cicilan_id','=',$request->id)->first();
        if($cek){
            $cek->update([
                'cicilan' => $request->cicilan,
                'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            ]);
            return redirect()->back()->with('success','Berhail Mengupdate ajuan.');
        }

        $tanggalBaru = Carbon::parse($request->tgl_jatuh_tempo);
        $tanggalLama = Carbon::parse($cicilan->tgl_jatuh_tempo); // bisa dari DB juga

        if ($tanggalBaru->month !== $tanggalLama->month || $tanggalBaru->year !== $tanggalLama->year) {
            return back()->withErrors(['tgl_jatuh_tempo' => 'Bulan dan tahun tidak boleh diubah.']);
        }

        $perubahan = PerubahanCicilan::create([
            'cicilan_id' => $request->id,
            'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            'cicilan' => $request->cicilan,
            'status' => 'Diajukan'
        ]);

        //mengirim nofitifkasi ke admin
        $admins = User::whereIn('role',['admin','superadmin'])->get();
        foreach ($admins as $admin) {
            # code...
            $admin->notify(new PerubahanCicilanNotification($perubahan, Auth::user()->name));
        }

        return redirect()->back()->with('success','Berhail membuat ajuan.');

    }

    public function destroy($id)
    {
        PerubahanCicilan::where('id','=',$id)->delete();
        return redirect()->back()->with('success','Berhasil membatalkan ajuan');
    }
}
