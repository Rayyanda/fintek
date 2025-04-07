<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\Mahasiswa\PenundaanController;
use App\Http\Controllers\Mahasiswa\StudentController;
use App\Http\Controllers\Superadmin\MahasiswaController;
use App\Http\Controllers\Superadmin\PenundaanController as SuperadminPenundaanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forbidden', function(){
    return view('error.401');
})->name('user.forbidden');

Route::prefix('mhs')->middleware(['auth','role:mahasiswa'])->group(function(){

    //penundaan
    Route::prefix('penundaan')->group(function(){

        //index
        Route::get('/',[PenundaanController::class,'index'])->name('mhs.penundaan.index');

        //create
        Route::get('/create',[PenundaanController::class,'create'])->name('mhs.penundaan.create');

        //store
        Route::post('/store',[PenundaanController::class,'store'])->name('mhs.penundaan.store');

        //delete
        Route::delete('/delete/{id}',[PenundaanController::class,'destroy'])->name('mhs.penundaan.delete');

        //pdf
        Route::get('/pdf/{student_id}',[PenundaanController::class,'pdf'])->name('mhs.penundaan.pdf');

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

    //keuangan
    Route::prefix('keuangan')->group(function(){

        //penundaan
        Route::prefix('penundaan')->group(function(){

            Route::get('/',[SuperadminPenundaanController::class,'index'])->name('superadmin.penundaan.index');

            Route::post('/status/update',[SuperadminPenundaanController::class,'update_status'])->name('superadmin.penundaan.upd_status');

            Route::get('/filter',[SuperadminPenundaanController::class,'search'])->name('superadmin.penundaan.filter');

            Route::get('/{student_id}/show',[SuperadminPenundaanController::class,'show'])->name('superadmin.penundaan.show');

        });

        //RKAT
        Route::prefix('rkat')->group(function(){

        });


    });

    Route::middleware(['role:admin,superadmin','auth'])->prefix('user')->group(function(){

        Route::prefix('mahasiswa')->group(function(){

            Route::get('/',[MahasiswaController::class,'index'])->name('superadmin.mahasiswa.index');

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
