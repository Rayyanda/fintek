<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\Controller;
use App\Models\Penundaan;
use App\Models\Pencicilan;
use App\Models\PerubahanCicilan;
use App\Models\Status;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PerubahanCicilanController extends Controller
{
    //
    public function index()
    {

        $tahunAjaran = TahunAjaran::where('is_active','=',1)->first();
        $penundaan = Penundaan::where('tahun_ajaran','=',$tahunAjaran->tahun_ajaran)
            ->with(['student','status','cicilans','cicilans.perubahan','student.user'])
            ->get();
        $status = Status::all();

        return view('penundaan-superadmin.pengajuan-perubahan.index',['penundaans'=>$penundaan,'status'=>$status, 'tahun_ajaran'=>$tahunAjaran]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cicilan_id' => 'required|exists:pencicilans,id',
            'tgl_jatuh_tempo' => 'required|date',
            'cicilan' => 'required|numeric',
        ]);

        PerubahanCicilan::where('cicilan_id','=',$request->cicilan_id)
            ->update([
                'status' => 'Disetujui'
            ]);

        Pencicilan::where('id','=',$request->cicilan_id)->update([
                'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
                'cicilan' => $request->cicilan,
            ]);
        //$cicilanController = App::make(CicilanController::class);
        //$cicilanController->edit($request);
        return redirect()->back()->with('success','Berhasil update status');

    }

    public function cancel(Request $request)
    {
        $validated = $request->validate([
            'cicilan_id' => 'required|exists:pencicilans,id',
        ]);

        PerubahanCicilan::where('cicilan_id','=',$request->cicilan_id)->update([
            'status' => 'Ditolak'
        ]);

        return redirect()->back()->with('success','Berhasil update status');
    }
}
