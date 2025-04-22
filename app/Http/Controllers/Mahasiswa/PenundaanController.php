<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\Controller;
use App\Models\Pencicilan;
use App\Models\Penundaan;
use App\Models\PenundaanTagihan;
use App\Models\Student;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenundaanController extends Controller
{
    //
    public function index()
    {
        $tahunajaran = TahunAjaran::where('is_active','=',1)->first();
        $dokumen = Penundaan::where('student_id','=',Auth::user()->student->student_id)
            ->where('tahun_ajaran','=',$tahunajaran->tahun_ajaran)
            ->where('semester','=',$tahunajaran->semester)
            ->with(['status','cicilans'])
            ->get();
        //return response()->json($dokumen);
        return view('penundaan-mahasiswa.index', compact('dokumen','tahunajaran'));
    }

    public function edit()
    {
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);

        $dokumen = Penundaan::where('tahun_ajaran','=',$tahunAjaran)->with(['student','status','cicilans'])->first();

        return view('penundaan-mahasiswa.edit', compact('dokumen'));
    }

    public function show(Request $request)
    {
        $tahun_ajaran = $request->tahun_ajaran;
        $semester = $request->semester;
        //$tahunajaran = TahunAjaran::where('is_active','=',1)->first();
        $dokumen = Penundaan::where('student_id','=',Auth::user()->student->student_id)
            ->where('tahun_ajaran','=',$tahun_ajaran)
            ->where('semester','=',$semester)
            ->with(['status','cicilans','student','student.user'])
            ->first();

        return view('penundaan-mahasiswa.show', compact('dokumen'));
    }


    public function create()
    {
        if(Auth::user()->student->nama_wali != null){
            $tahunAjaran = TahunAjaran::all();
            $tahunajaran = TahunAjaran::where('is_active','=',1)->first();
            $cek = Penundaan::where('student_id','=',Auth::user()->student->student_id)
                ->where('tahun_ajaran','=',$tahunajaran->tahun_ajaran)
                ->where('semester','=',$tahunajaran->semester)
                ->first();

            if($cek)
            {
                //jika sudah ada, kembali dengan pesan error
                return redirect()->back()->with('error','Pengajuan penundaan sudah ada. Silahkan edit ajukan perubahan untuk merubah');
            }
            // $tagihan = Penundaan::where('student_id','=',Auth::user()->student->student_id)
            // ->first();
            return view('penundaan-mahasiswa.create',['tahun_ajaran'=>$tahunAjaran]);
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

        $opsi = $request->opsi;

        $sks = Auth::user()->student->jenis_kelas == 'Pagi' ? 150000 * 20 : 175000 * 20;

        $cicilanController = App::make(CicilanController::class);

        $total = ($opsi == 1) ? ($request->jumlah_tunggakan + $sks) : $request->jumlah_tunggakan;

        $penundaan = Penundaan::create([
            'student_id' => Auth::user()->student->student_id,
            'opsi_penundaan'=>$request->opsi,
            'jumlah_tunggakan'=> $total,
            'jenis_tagihan'=> $opsi == 1 ? 'BPP & SKS' : "BPP",
            'alasan' => $request->alasan,
            'tahun_ajaran'=> $request->tahun_ajaran,
            'semester'=> $request->semester,
            'status_id' => 1
        ]);

        if($opsi == 1)
        {
            $cicilanController->opsi1($penundaan->id,$penundaan->jumlah_tunggakan, $sks);
        }else{
            $cicilanController->opsi2($penundaan->id,$penundaan->jumlah_tunggakan);
        }

        //membuat notifikasi ke admin
        //$admins = User::whereIn('role',['admin','superadmin'])->get();

        return redirect()->route('mhs.penundaan.index')->with('success','Dokumen telah dibuat');
    }

    public function destroy(Request $request, $id)
    {
        $penundaan = Penundaan::find($id);
        $penundaan->delete();
        return redirect()->route('mhs.penundaan.index')->with('success','Dokumen telah dihapus');
    }
    public function pdf($student_id)
    {
        $penundaan = Penundaan::where('student_id', '=',$student_id)->with(['student','status','cicilans'])->first();
        $pdf = Pdf::loadView('pdf.ajuan',['penundaans'=>$penundaan])->setPaper('f4','potrait');
        return $pdf->stream('ajuan.pdf');
        //return view('pdf.ajuan',['penundaans'=>$penundaan]);
    }
}
