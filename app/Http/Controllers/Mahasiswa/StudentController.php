<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //
    public function edit()
    {
        return view('profile.mahasiswa.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => 'required',
            'alamat' => 'required',
            'fakultas'=>'required',
            'prodi' => "required",
            'jenis_kelas'=> 'required',
            'semester' => 'required|integer',
            'ipk'=>'required|decimal:2',
            'alamat_kantor' => 'nullable',
            'profile' =>'image|mimes:png,jpg,jpeg|max:2048',

        ]);
        $user = Student::where('id','=',auth()->user()->student->id)->first();

        $imgProfile = $request->file('profile');

        if($imgProfile){
            //menghapus gambar lama
            Storage::delete('public/images/profil/mhs/'.$user->profile);
            //menyimpan gambar baru
            $imgProfile->storeAs('public/images/profil/mhs', $imgProfile->hashName());

        }else{
            $imgProfile = null;
        }

        $user->update([
            'no_telp' => $request->no_telp,
            'jenis_kelas'=> $request->jenis_kelas,
            'alamat' => $request->alamat,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
            'ipk' => $request->ipk,
            'alamat_kantor' => $request->alamat_kantor,
            'profile' => $imgProfile ? $imgProfile->hashName() : $user->profile,
            'nama_wali' =>$request->nama_wali,
            'telp_wali' =>$request->telp_wali,
            'alamat_rumah' =>$request->alamat_rumah,
            'pekerjaan_wali' =>$request->pekerjaan_wali,
            'jabatan' =>$request->jabatan,
            'alamat_kantor_wali' =>$request->alamat_kantor_wali,
        ]);

        return redirect()->route('auth.profile')->with('success','Profile Updated');
    }
}
