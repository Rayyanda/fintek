<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Penundaan;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenundaanController extends Controller
{
    //
    public function index()
    {
        $penundaan = Penundaan::with(['student','status','cicilans','cicilans.perubahan'])->get();
        $status = Status::all();

        // $admin = Auth::user()->notifications;
        // if (isset($admin)) {
        //     # code...
        //     $admin->markAsRead();
        // }

        return view('penundaan-superadmin.index',['penundaans'=>$penundaan,'status'=>$status]);
    }

    public function search(Request $request)
    {
        $status_id = $request->status_id;
        $penundaan = Penundaan::where('status_id','=',$status_id)->with(['student','status','cicilans'])->get();
        $status = Status::all();
        return view('penundaan-superadmin.index',['penundaans'=>$penundaan,'status'=>$status]);
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'id'=> 'required',
            'status_id' => 'required',
        ]);

        $dokumen = Penundaan::where('id','=',$request->id)->update([
            'status_id' => $request->status_id,
        ]);

        return redirect()->route('superadmin.penundaan.index')->with('success','Berhasil mengupdate status');
    }

    public function show(Request $request,$student_id)
    {
        $tahun_ajaran = $request->tahun_ajaran;
        $semester = $request->semester;
        $student = Penundaan::where('student_id','=',$student_id)
            ->where('tahun_ajaran','=',$tahun_ajaran)
            ->where('semester','=', $semester)
            ->with(['student.user','student','status','cicilans','cicilans.perubahan'])
            ->first();
        return view('penundaan-superadmin.show',['penundaan'=>$student]);
    }

    public function notifikasi()
    {
        return Auth::user()->unreadNotifications;
    }
}
