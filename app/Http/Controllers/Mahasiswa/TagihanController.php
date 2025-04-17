<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagihanController extends Controller
{
    //
    public function index()
    {
        $tagihan = Tagihan::where('student_id', auth()->user()->student->student_id)->with(['student','penundaan','student.user'])->get();

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

        Tagihan::create([
            'tagihan_id'=> Str::uuid(),
            'student_id'=> auth()->user()->student->student_id,
            'tahun_ajaran'=>$validated['tahun_ajaran'],
            'semester'=>$validated['semester'],
            'nominal'=>$validated['nominal'],
            'jenis_tagihan'=>$validated['jenis_tagihan'],
            'status'=> 'Belum Divalidasi'
        ]);

        return redirect()->route('mhs.tagihan.index')->with('success','Tagihan berhasil ditambahkan. Silahkan tunggu divalidasi oleh Admin');
    }
}
