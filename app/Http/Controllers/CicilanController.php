<?php

namespace App\Http\Controllers;

use App\Models\Pencicilan;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Notifications\StudentNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SweetAlert2\Laravel\Swal;

class CicilanController extends Controller
{
    public function index()
    {
        $tanggalSekarang = Carbon::now();
        //$tahun = $tanggalSekarang->year;
        $bulan = $tanggalSekarang->month;
        $tahunAjaran = TahunAjaran::where('is_active','=',1)->first();
        $pencicilans = Pencicilan::whereMonth('tgl_jatuh_tempo','=',$bulan)
            ->with(['penundaan','penundaan.student','penundaan.student.user','perubahan'])
            ->get();
        return view('pencicilan-berjalan.index',compact('tahunAjaran','pencicilans'));
    }

    public function opsi1($penundaan_id, $tunggakan, $sks)
    {
        //membuat tanggal
        $today = date('d');
        $tanggalSekarang = Carbon::now();
        $tahun = $tanggalSekarang->year;
        $bulan = $tanggalSekarang->month;
        $tanggalAwal = Carbon::create($tahun, $bulan, 20); // tanggal 20 bulan awal
        if($tunggakan > 10000000)
        {
            $setengah = $tunggakan / 2;
            //membuat cicilan pertama
            $cicilan1 = Pencicilan::create([
                'penundaan_id' => $penundaan_id,
                'tgl_jatuh_tempo' => $tahun .'-'.$bulan.'-'.$today+2,
                'cicilan' => $setengah,
                'status' => 'Belum Lunas',
            ]);
            //
            $cicilanLanjut = $setengah + $sks;
            //menambahkan cicilan berikutnya
            for ($i=1; $i <= 4 ; $i++) {
                $tglJatuhTempo = $tanggalAwal->copy()->addMonths($i - 1); // tetap tanggal 20, tapi tambah bulan ke-0, 1, 2, dst
                $cicilan = Pencicilan::create([
                    'penundaan_id' => $penundaan_id,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'cicilan' => $cicilanLanjut / 4 ,
                    'status' => 'Belum Lunas',
                ]);
            }
        }else{
            $total = $tunggakan + $sks;
            for ($i=1; $i <= 5 ; $i++) {
                $tglJatuhTempo = $tanggalAwal->copy()->addMonths($i - 1); // tetap tanggal 20, tapi tambah bulan ke-0, 1, 2, dst
                $cicilan = Pencicilan::create([
                    'penundaan_id' => $penundaan_id,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'cicilan' => $total / 5 ,
                    'status' => 'Belum Lunas',
                ]);

            }
        }
    }

    public function opsi2($penundaan_id, $tunggakan, $jumlah_cicilan = 3)
    {
        $today = date('d');
        $tanggalSekarang = Carbon::now();
        $tahun = $tanggalSekarang->year;
        $bulan = $tanggalSekarang->month;
        $tanggalAwal = Carbon::create($tahun, $bulan, 20); // tanggal 20 bulan awal
        if($tunggakan > 10000000){
            $setengah = $tunggakan /2;
            $cicilan1 = Pencicilan::create([
                'penundaan_id' => $penundaan_id,
                'tgl_jatuh_tempo' => $tahun .'-'.$bulan.'-'.$today+2,
                'cicilan' => $setengah,
                'status' => 'Belum Lunas',
            ]);
            for ($i=1; $i <= 2 ; $i++) {
                $tglJatuhTempo = $tanggalAwal->copy()->addMonths($i - 1);
                $cicilan = Pencicilan::create([
                    'penundaan_id' => $penundaan_id,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'cicilan' => $setengah / 2 ,
                    'status' => 'Belum Lunas',
                ]);
            }
        }else{
            for ($i=1; $i <= $jumlah_cicilan ; $i++) {
                $tglJatuhTempo = $tanggalAwal->copy()->addMonths($i - 1);
                $cicilan = Pencicilan::create([
                    'penundaan_id' => $penundaan_id,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'cicilan' => $tunggakan / $jumlah_cicilan ,
                    'status' => 'Belum Lunas',
                ]);
            }
        }

        // Pencicilan::create([
        //     'penundaan_id' => $penundaan_id,
        //     'tgl_jatuh_tempo' => ($bulan == 12 ) ? $tahun+1 .'-'.$bulan+4 . '-'.'20' : $tahun .'-'.$bulan+4 .'-'.'20',
        //     'cicilan' => $sks ,
        //     'status' => 'Belum Lunas',
        // ]);
    }

    //function untuk upload bukti bayar
    public function update(Request $request, $penundaan_id)
    {
        $validated = $request->validate([
            'id' => 'required|exists:pencicilans,id',
            'bukti'=>'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $bukti = $request->file('bukti');
        $bukti->storeAs('public/images/keuangan/pelunasan', $bukti->hashName());
        $today = date('Y-m-d');

        $pencicilan = Pencicilan::where('id','=',$request->id)
        ->where('penundaan_id','=',$penundaan_id)->update([
            'bukti' => $bukti->hashName(),
            'status' => 'Lunas',
            'tgl_pembayaran' => $today,
        ]);

        return redirect()->route('mhs.penundaan.index')->with('success','Berhasil Melakukan Pembayaran');

    }
    //function untuk mengubah data cicilan
    public function edit(Request $request)
    {
        $validated = $request->validate([
            'cicilan_id' => 'required|exists:pencicilans,id',
            'tgl_jatuh_tempo' => 'required|date',
            'cicilan' => 'required|numeric',
        ]);



        //return redirect()->back()->with('success','Berhasil update data');
    }

    public function set_lunas(Request $request)
    {
        $request->validate([
            'cicilan_id'=> 'required|exists:pencicilans,id'
        ]);

        $pencicilan = Pencicilan::where('id','=',$request->cicilan_id)->update([
            'status' => "Lunas"
        ]);

        return back()->with('success','Berhasil menandai sebagai lunas');
    }

    public function sendPersonalWarning(Request $request)
    {
        $validate = $request->validate([
            'user_id',
            'cicilan_id'
        ]);

        $student = User::where('user_id','=',$request->user_id)->first();
        $cicilan = Pencicilan::where('id','=',$request->cicilan_id)->first();
        $student->notify(new StudentNotification($cicilan));

        Swal::success([
            'title' => 'Berhasil Mengirim email'
        ]);

        return response()->json([
            'status'=>'success',
            'message' => 'Berhasil mengirim pesan'
        ], 200);
        //return back()->with('success','Berhasil mengirim peringatan');
    }

    public function sendWarning(Request $request)
    {
        $validate = $request->validate([
            'user.*.*' => 'required|min:1'
        ]);

        $data = $request->input('user');

        foreach ($data as $userId => $dt) {
            # code...
            foreach ($dt as $cicilan_id => $value) {
                # code...
                $student = User::where('user_id','=', $userId)->first();
                $pencicilans = Pencicilan::where('id','=',$cicilan_id)
                    ->with(['penundaan','penundaan.student','penundaan.student.user','perubahan'])
                    ->first();
                $student->notify(new StudentNotification($pencicilans));
            }
        }

        Swal::success([
            'title' => 'Berhasil Mengirim email'
        ]);

        return response()->json([
            'status'=>'success',
            'message' => 'Berhasil mengirim pesan'
        ], 200);
        //return back()->with('success','Berhasil mengirim pesan');
    }
}
