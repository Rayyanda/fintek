<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    //
    public function index()
    {
        $tagihan = Tagihan::where('student_id', auth()->user()->student->student_id)->with(['student','penundaan','student.user'])->get();

        return view('tagihan.index',['tagihan'=>$tagihan]);
    }
}
