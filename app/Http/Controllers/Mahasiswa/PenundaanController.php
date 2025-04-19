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

        $dokumen = Penundaan::whereHas('penundaans', function ($query) {
            $query->student_id = Auth::user()->student_id;
        })->with(['penundaans.pencicilan'])
        ->get();
        //return response()->json($dokumen);
        return view('penundaan-mahasiswa.index', compact('dokumen'));
    }

    public function edit()
    {
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);

        $dokumen = Penundaan::where('tahun_ajaran','=',$tahunAjaran)->with(['student','status','cicilans'])->first();

        return view('penundaan-mahasiswa.edit', compact('dokumen'));
    }


    public function create($tagihan_id)
    {
        if(Auth::user()->student->nama_wali != null){
            $tahunAjaran = TahunAjaran::all();
            $tagihan = Tagihan::where('tagihan_id','=',$tagihan_id)
                ->with(['student','student.user','penundaans'])
                ->first();
            return view('penundaan-mahasiswa.create',['tagihan'=> $tagihan,'tahun_ajaran'=>$tahunAjaran]);
        }else{
            return redirect()->back()->with('error','Wali mahasiswa belum diisi. Silahkan isi dibagian Profil Anda');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => 'required|exists:tagihans,tagihan_id',
            'jumlah_tunggakan' => 'required|integer',
            'alasan'=> 'required',
            'tahun_ajaran'=>'required',
            'jenis_tagihan'=> 'required',
            'semester'=>'required',
            'opsi'=>'required',
        ]);
        $sks = Auth::user()->student->jenis_kelas == 'Pagi' ? 150000 * 20 : 175000 * 20;

        $cicilanController = App::make(CicilanController::class);

        $tagihan = Tagihan::where('tahun_ajaran','=',$request->tahun_ajaran)
            ->where('semester','=',$request->semester)
            ->where('jenis_tagihan','=',"SKS")
            ->where('student_id','=',Auth::user()->student->student_id)
            ->first();


            //jika belum ada tagihan sks, periksa opsi penundaan
            if($request->opsi == 1)
            {
                //membuat uuid tagihan sks
                $uuidSks = Str::uuid();

                //membuat tagihan sks
                if($tagihan === null){
                    $tagihan = Tagihan::create([
                        'student_id'=>Auth::user()->student->student_id,
                        'tagihan_id'=> $uuidSks,
                        'tahun_ajaran'=> $request->tahun_ajaran,
                        'semester'=> $request->semester,
                        'nominal'=>$sks,
                        'jenis_tagihan'=> "SKS",
                        'status'=> 'Penundaan'
                    ]);
                }

                //opsi penundaan 1 :  (BPP + SKS (20) + Tagihan Sebelumnya) / 5
                $total = $request->jumlah_tunggakan + $tagihan->nominal;
                $penundaan = Penundaan::create([
                    'opsi_penundaan'=>$request->opsi,
                    'jumlah_tunggakan'=> $total,
                    'jenis_tagihan'=> "BPP & SKS",
                    'alasan' => $request->alasan,
                    'tahun_ajaran'=> $request->tahun_ajaran,
                    'semester'=> $request->semester,
                    'status_id' => 1
                ]);

                //mengisi pivot tagihan di table penundaan tagihan
                DB::table('penundaan_tagihans')->insert([
                    [
                        'penundaan_id' => $penundaan->id,
                        'tagihan_id'=>$request->tagihan_id,
                        'student_id'=>Auth::user()->student->student_id
                    ],
                    [
                        'penundaan_id' => $penundaan->id,
                        'tagihan_id'=>$uuidSks,
                        'student_id'=>Auth::user()->student->student_id
                    ],
                ]);


                //membuat cicilan dengan opsi
                $cicilanController->opsi1($penundaan->id,$request->jumlah_tunggakan,$sks);
            }else{
                //pada opsi 2 : SKS tidak dimasukkan kedalam total pencicilan, sehingga tagihan sks tetap dibuat namun tidak ada cicilan
                //membuat penundaan BPP saja
                $penundaan = Penundaan::create([
                    'opsi_penundaan'=>$request->opsi,
                    'jumlah_tunggakan'=>$request->jumlah_tunggakan,
                    'jenis_tagihan'=>$request->jenis_tagihan,
                    'alasan' => $request->alasan,
                    'tahun_ajaran'=> $request->tahun_ajaran,
                    'semester'=> $request->semester,
                    'status_id' => 1
                ]);

                //membuat pencicilan penundaan BPP
                $cicilanController->opsi2($penundaan->id,$penundaan->jumlah_tunggakan);

                //mengisi pivot tagihan di table penundaan_tagihan
                $penundaan->tagihans()->attach([$request->tagihan_id]);

                //membuat tagihan SKS
                $tagihanSks = Tagihan::create([
                    'student_id'=>Auth::user()->student->student_id,
                    'tagihan_id'=> Str::uuid(),
                    'tahun_ajaran'=> $request->tahun_ajaran,
                    'semester'=> $request->semester,
                    'nominal'=>$sks,
                    'jenis_tagihan'=> "SKS",
                ]);
                //note : tagihan SKS tidak dianggap sebagai penundaan


            }

        Tagihan::where('tagihan_id','=',$request->tagihan_id)->update([
            'status' => 'Penundaan'
        ]);

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
        $penundaan = Penundaan::where('student_id', '=',$student_id)->with(['student','status','cicilans'])->first();
        $pdf = Pdf::loadView('pdf.ajuan',['penundaans'=>$penundaan])->setPaper('f4','potrait');
        return $pdf->stream('ajuan.pdf');
        //return view('pdf.ajuan',['penundaans'=>$penundaan]);
    }
}
