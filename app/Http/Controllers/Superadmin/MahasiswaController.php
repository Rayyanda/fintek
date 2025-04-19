<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //
    public function index()
    {
        $mahasiswa = Student::with('user','tagihan','tagihan.penundaan.status','tagihan.penundaan.cicilans')->get();
        return view('mahasiswa.index', ['mahasiswa'=>$mahasiswa]);
    }
}
