<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Penundaan;
use App\Models\Status;
use Illuminate\Http\Request;

class PerubahanCicilanController extends Controller
{
    //
    public function index()
    {
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);

        $penundaan = Penundaan::where('tahun_ajaran','=',$tahunAjaran)->with(['student','status','cicilans','cicilans.perubahan','student.user'])->get();
        $status = Status::all();

        return view('penundaan-superadmin.pengajuan-perubahan.index',['penundaans'=>$penundaan,'status'=>$status]);
    }
}
