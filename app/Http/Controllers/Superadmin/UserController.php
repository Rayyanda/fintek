<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::where('role','!=','superadmin')->get();
        return view('users.index',compact('users'));
    }

    public function readnotif(Request $request)
    {
        $val = $request->validate(['id'=>'required|exists:notifications,id']);
        $notification = Auth::user()->notifications;
        $notification->markAsRead();
        return redirect()->back()->with('success','Ditandai telah dibaca');
    }

}
