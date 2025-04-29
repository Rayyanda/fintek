<?php

use App\Http\Controllers\CicilanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\Mahasiswa\PenundaanController;
use App\Http\Controllers\Mahasiswa\PerubahanCicilanController;
use App\Http\Controllers\Mahasiswa\StudentController;
use App\Http\Controllers\Mahasiswa\TagihanController;
use App\Http\Controllers\RKATController;
use App\Http\Controllers\Superadmin\DetailRKATController;
use App\Http\Controllers\Superadmin\MahasiswaController;
use App\Http\Controllers\Superadmin\PenundaanController as SuperadminPenundaanController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\TagihanController as SuperadminTagihanController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing-bro',function(){
    return view('layouts.app2');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forbidden', function(){
    return view('error.401');
})->name('user.forbidden');

Route::prefix('mhs')->middleware(['auth','role:mahasiswa'])->group(function(){

    //Tagihan
    // Route::prefix('tagihan')->group(function(){

    //     //index
    //     Route::get('/',[TagihanController::class,'index'])->name('mhs.tagihan.index');

    //     //create
    //     Route::post('/create',[TagihanController::class,'store'])->name('mhs.tagihan.store');

    // });

    //penundaan
    Route::prefix('penundaan')->group(function(){

        //index
        Route::get('/',[PenundaanController::class,'index'])->name('mhs.penundaan.index');

        //create
        Route::get('/create',[PenundaanController::class,'create'])->name('mhs.penundaan.create');

        //show
        Route::get('/show',[PenundaanController::class,'show'])->name('mhs.penundaan.show');

        //store
        Route::post('/store',[PenundaanController::class,'store'])->name('mhs.penundaan.store');

        //delete
        Route::delete('/delete/{id}',[PenundaanController::class,'destroy'])->name('mhs.penundaan.delete');

        //pdf
        Route::get('/pdf/{student_id}',[PenundaanController::class,'pdf'])->name('mhs.penundaan.pdf');

        //bayar
        Route::post('/{penundaan_id}/pay',[CicilanController::class,'update'])->name('mhs.penundaan.pay');

        //pengajuan perubahan
        Route::post('/perubahan-cicilan',[PerubahanCicilanController::class,'store'])->name('mhs.perubahan-cicilan.store');

        //batal pengajuan perubahan
        Route::delete('/perubahan-cicilan/{id}',[PerubahanCicilanController::class,'destroy'])->name('mhs.perubahan-cicilan.delete');

    });

    //profile
    Route::prefix('my-profile')->group(function(){

        //edit page
        //Route::get('/edit',[StudentController::class,'edit'])->name('mhs.profile.edit');

        //update
        Route::post('update',[StudentController::class,'update'])->name('mhs.profile.edit');

    });

});

//superadmin
Route::prefix('superadmin')->middleware(['auth','role:superadmin'])->group(function(){

    //get notification
    Route::get('/notif',[SuperadminPenundaanController::class,'notifikasi'])->name('superadmin.notification.get');

    Route::get('/notifikasi',function(){
        $notifikasi = Auth::user()->notifications;
        return view('notification',['notifications'=>$notifikasi]);
    })->name('superadmin.notifikasi.index');

    Route::post('/notifikasi/read',[UserController::class,'readnotif'])->name('superadmin.notification.read');

    //keuangan
    Route::prefix('keuangan')->group(function(){

        //penundaan
        Route::prefix('penundaan')->group(function(){

            Route::get('/',[SuperadminPenundaanController::class,'index'])->name('superadmin.penundaan.index');

            Route::post('/status/update',[SuperadminPenundaanController::class,'update_status'])->name('superadmin.penundaan.upd_status');

            Route::get('/filter',[SuperadminPenundaanController::class,'search'])->name('superadmin.penundaan.filter');

            Route::get('/{student_id}/show',[SuperadminPenundaanController::class,'show'])->name('superadmin.penundaan.show');

        });

        //pencicilan
        Route::prefix('pencicilan')->group(function(){

            Route::get('/',[CicilanController::class,'index'])->name('superadmin.pencicilan.index');

            //set lunas
            Route::post('/set-lunas',[CicilanController::class,'set_lunas'])->name('superadmin.pencicilan.set-lunas');

            //send warning
            Route::post('/send-personl-warning',[CicilanController::class,'sendPersonalWarning'])->name('superadmin.pencicilan.send-personal-warning');

            //send to all student
            Route::post('/send-warning',[CicilanController::class,'sendWarning'])->name('superadmin.send-warning');

        });

        //Pengajuan Perubahan Cicilan
        Route::prefix('perubahan-cicilan')->group(function(){

            //index
            Route::get('/',[\App\Http\Controllers\Superadmin\PerubahanCicilanController::class,'index'])->name('superadmin.perubahan-cicilan.index');

            //update
            Route::post('/update',[\App\Http\Controllers\Superadmin\PerubahanCicilanController::class,'update'])->name('superadmin.perubahan-cicilan.update');

            //tolak ajuan
            Route::post('/reject',[\App\Http\Controllers\Superadmin\PerubahanCicilanController::class,'cancel'])->name('superadmin.perubahan-cicilan.reject');

        });

        //RKAT
        Route::prefix('rkat')->group(function(){

            Route::get('/',[RKATController::class,'index'])->name('superadmin.rkat.index');

            Route::post('/store',[RKATController::class,'store'])->name('superadmin.rkat.store');

            Route::get('/{rkat_id}/show',[RKATController::class,'show'])->name('superadmin.rkat.show');

            Route::post('/detail/store',[DetailRKATController::class,'store'])->name('superadmin.rkat.detail.store');

        });

        //tagihan
        Route::prefix('tagihan')->group(function(){

            //index
            Route::get('/',[SuperadminTagihanController::class,'index'])->middleware(['auth','role:superadmin,admin'])->name('admin.tagihan.index');

            Route::post('/update',[SuperadminTagihanController::class,'update'])->middleware(['auth','role:superadmin,admin'])->name('admin.tagihan.update');

        });


    });

    //users
    Route::prefix('users')->group(function(){

        //index
        Route::get('/',[UserController::class,'index'])->name('superadmin.users.index');

        //setting
        Route::get('/settings',function(){
            return view('superadmin.settings');
        })->name('superadmin.settings');

    });

    Route::middleware(['role:admin,superadmin','auth'])->prefix('user')->group(function(){

        Route::prefix('mahasiswa')->group(function(){

            Route::get('/',[MahasiswaController::class,'index'])->name('superadmin.mahasiswa.index');

        });

        Route::prefix('tahun_ajaran')->group(function(){

            //index
            Route::get('/',[TahunAjaranController::class,'index'])->name('tahunAjaran.index');

            //store
            Route::post('/store',[TahunAjaranController::class,'store'])->name('tahunAjaran.store');

            //delete
            Route::delete('/{id}/delete',[TahunAjaranController::class,'destroy'])->name('tahunAjaran.delete');

            //update
            Route::post('/{id}/update',[TahunAjaranController::class,'update'])->name('tahunAjaran.update');

        });

    });


});


Route::middleware(['auth','role:dosen,admin,superadmin'])->group(function(){

    Route::prefix('inventaris')->group(function(){

        Route::get('/',[InventarisController::class,'index'])->name('inventaris.index');

        Route::post('/store',[InventarisController::class,'store'])->name('inventaris.store');

        Route::delete('/delete',[InventarisController::class,'destroy'])->name('inventaris.delete');

    });

});

//umum
Route::middleware('auth')->group(function(){

    //profile
    Route::get('/my-profile',[HomeController::class,'profile'])->name('auth.profile');


});
