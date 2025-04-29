<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    //
    public function index()
    {
        $tagihan = Tagihan::where('student_id', Auth::user()->student->student_id)->with(['student','penundaans','student.user'])->get();

        return view('tagihan.index',['tagihan'=>$tagihan]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran'=>'required',
            'semester'=>'required',
            'nominal'=>'required',
            'jenis_tagihan'=>'required',
        ]);

        //mengecek terlebih dahulu (memanggil fungsi cek tagihan)
        $cek = $this->cekTagihan($request);
        if($cek){
            return redirect()->back()->with('error','Tagihan sudah ada');
        }

        //jika tidak ada, maka akan membuat tagihan baru
        Tagihan::create([
            'tagihan_id'=> Str::uuid(),
            'student_id'=> Auth::user()->student->student_id,
            'tahun_ajaran'=>$validated['tahun_ajaran'],
            'semester'=>$validated['semester'],
            'nominal'=>$validated['nominal'],
            'jenis_tagihan'=>$validated['jenis_tagihan'],

        ]);

        return redirect()->route('mhs.tagihan.index')->with('success','Tagihan berhasil ditambahkan. Silahkan tunggu divalidasi oleh Admin');
    }

    //function untuk mengecek bahwa tagihan BPP dan SKS di tahun ajaran dan semester sudah ada atau belum
    public function cekTagihan(Request $request)
    {
        $tahun_ajaran = $request->tahun_ajaran;
        $semester = $request->semester;
        $jenis_tagihan = $request->jenis_tagihan;
        $student_id = Auth::user()->student->student_id;
        $tagihan = Tagihan::where('student_id',$student_id)
            ->where('tahun_ajaran','=',$tahun_ajaran)
            ->where('semester','=',$semester)
            ->where('jenis_tagihan','=',$jenis_tagihan)
            ->first();
        if($tagihan){
            return true;
        }else{
            return false;
        }
    }
}
