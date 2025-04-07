<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Penundaan;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Http\Request;

class PenundaanController extends Controller
{
    //
    public function index()
    {
        $penundaan = Penundaan::with(['student','status','cicilan'])->paginate(10);
        $status = Status::all();

        return view('penundaan-superadmin.index',['penundaans'=>$penundaan,'status'=>$status]);
    }

    public function search(Request $request)
    {
        $status_id = $request->status_id;
        $penundaan = Penundaan::where('status_id','=',$status_id)->with(['student','status','cicilan'])->paginate(10);
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

    public function show($student_id)
    {
        $student = Student::where('student_id','=',$student_id)->with(['user','penundaan','penundaan.status','penundaan.cicilan'])->first();
        return view('penundaan-superadmin.show',['student'=>$student]);
    }
}
