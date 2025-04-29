<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //
    public function index()
    {
        $tahunAjaran = TahunAjaran::where('is_active','=',1)->first();
        $mahasiswa = Student::with('user','penundaan','penundaan.status','penundaan.cicilans')->get();
        return view('mahasiswa.index', ['mahasiswa'=>$mahasiswa,'tahun_ajaran'=>$tahunAjaran]);
    }
}
