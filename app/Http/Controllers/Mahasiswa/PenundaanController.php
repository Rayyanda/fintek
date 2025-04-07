<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\Controller;
use App\Models\Pencicilan;
use App\Models\Penundaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PenundaanController extends Controller
{
    //
    public function index()
    {
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);

        $dokumen = Penundaan::where('tahun_ajaran','=',$tahunAjaran)->where('student_id','=',auth()->user()->student->student_id)->with(['student','status','cicilan'])->first();

        return view('penundaan-mahasiswa.index', compact('dokumen'));
    }

    public function edit()
    {
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);

        $dokumen = Penundaan::where('tahun_ajaran','=',$tahunAjaran)->with(['student','status','cicilan'])->first();

        return view('penundaan-mahasiswa.edit', compact('dokumen'));
    }


    public function create()
    {
        if(auth()->user()->student->nama_wali != null){
            return view('penundaan-mahasiswa.create');
        }else{
            return redirect()->back()->with('error','Wali mahasiswa belum diisi. Silahkan isi dibagian Profil Anda');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah_tunggakan' => 'required|integer',
            'alasan'=> 'required',
            'tahun_ajaran'=>'required',
            'semester'=>'required',
            'opsi'=>'required',
        ]);

        $penundaan = Penundaan::create([
            'student_id'=> auth()->user()->student->student_id,
            'opsi_penundaan'=>$request->opsi,
            'jumlah_tunggakan'=>$request->jumlah_tunggakan,
            'alasan' => $request->alasan,
            'tahun_ajaran'=> $request->tahun_ajaran,
            'semester'=> $request->semester,
            'status_id' => 1
        ]);

        $sks = auth()->user()->student->jenis_kelas == 'Pagi' ? 150000 * 20 : 175000 * 20;

        $cicilanController = App::make(CicilanController::class);
        $cicilanController->setCicilan($penundaan->id,$request->jumlah_tunggakan, $request->opsi, $sks);

        return redirect()->route('mhs.penundaan.index')->with('success','Dokumen telah dibuat');

    }

    public function destroy(Request $request, $id)
    {
        $penundaan = Penundaan::findOrFail($id)->first();
        $penundaan->delete();
        return redirect()->route('mhs.penundaan.index')->with('success','Dokumen telah dihapus');
    }

    private function setCicilan($tunggakan)
    {
        $sks = 20 * 150000;
    }

    public function pdf($student_id)
    {
        $penundaan = Penundaan::where('student_id', '=',$student_id)->with(['student','status','cicilan'])->first();
        $pdf = Pdf::loadView('pdf.ajuan',['penundaans'=>$penundaan])->setPaper('f4','potrait');
        return $pdf->stream('ajuan.pdf');
        //return view('pdf.ajuan',['penundaans'=>$penundaan]);
    }
}
