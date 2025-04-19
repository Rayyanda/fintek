<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    //index
    public function index()
    {
        $tagihan = Tagihan::with(['student','student.user','penundaans'])->get();
        return view('tagihan-super-admin.index',['tagihan'=>$tagihan]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required',
            'tagihan_id'=>'required|exists:tagihans,tagihan_id',
            'student_id'=>'required|exists:tagihans,student_id'
        ]);

        $tagihan = Tagihan::where('student_id','=',$request->student_id)
            ->where('tagihan_id','=',$request->tagihan_id)->first();

        $tagihan->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.tagihan.index')->with('success','Berhasil update status tagihan');
    }
}
