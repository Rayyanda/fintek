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
        $mahasiswa = Student::with('user','penundaan','penundaan.status','penundaan.cicilan')->paginate(20);
        return view('mahasiswa.index', ['mahasiswa'=>$mahasiswa]);
    }
}
