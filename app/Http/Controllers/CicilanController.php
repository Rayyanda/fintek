<?php

namespace App\Http\Controllers;

use App\Models\Pencicilan;
use Illuminate\Http\Request;

class CicilanController extends Controller
{
    //
    public function setCicilan($penundaan_id, $tunggakan, $opsi, $sks)
    {
        $today = date('d');
        $bulan = date('m');
        $tahun = date('Y');
        $total = $tunggakan;
        $setengah = $total / 2;
        if($total > 10000000){
            Pencicilan::create([
                'penundaan_id' => $penundaan_id,
                'tgl_jatuh_tempo' => $tahun .'-'.$bulan.'-'.$today+2,
                'cicilan' => $setengah,
                'status' => 'Belum Lunas',
            ]);
            switch($opsi)
            {
                case 1:
                    $this->opsi1($penundaan_id,$setengah,$sks,4);
                    break;
                case 2:
                    $this->opsi2($penundaan_id,$setengah,2, $sks);
            }
            // for ($i=1; $i <= 4; $i++) {
            //     Pencicilan::create([
            //         'penundaan_id' => $penundaan_id,
            //         'tgl_jatuh_tempo' => ($bulan = 12) ? $tahun+1 .'-'.$bulan+$i.'-'.'20' : $tahun .'-'.$bulan+$i.'-'.'20',
            //         'cicilan' => $setengah / 4 ,
            //         'status' => 'Belum Lunas',
            //     ]);
            // }
        }else{
            switch($opsi)
            {
                case 1:
                    $this->opsi1($penundaan_id,$total,$sks,5);
                    break;
                case 2:
                    $this->opsi2($penundaan_id,$total,3, $sks);
            }
            // for ($i=0; $i <= 4; $i++) {
            //     Pencicilan::create([
            //         'penundaan_id' => $penundaan_id,
            //         'tgl_jatuh_tempo' => ($bulan == 12 ) ? $tahun+1 .'-'.$bulan+$i.'-'.'20' : $tahun .'-'.$bulan+$i.'-'.'20',
            //         'cicilan' => $total / 5 ,
            //         'status' => 'Belum Lunas',
            //     ]);
            // }
        }

        return true;
    }

    public function opsi1($penundaan_id, $tunggakan, $sks, $jumlah_cicilan)
    {
        $today = date('d');
        $bulan = date('m');
        $tahun = date('Y');
        for ($i=1; $i <= $jumlah_cicilan ; $i++) {
            Pencicilan::create([
                'penundaan_id' => $penundaan_id,
                'tgl_jatuh_tempo' => ($bulan == 12 ) ? $tahun+1 .'-'.$bulan+$i.'-'.'20' : $tahun .'-'.$bulan+$i.'-'.'20',
                'cicilan' => ($tunggakan + $sks) / $jumlah_cicilan ,
                'status' => 'Belum Lunas',
            ]);
        }
    }

    public function opsi2($penundaan_id, $tunggakan, $jumlah_cicilan, $sks)
    {
        $today = date('d');
        $bulan = date('m');
        $tahun = date('Y');
        for ($i=1; $i <= $jumlah_cicilan ; $i++) {
            Pencicilan::create([
                'penundaan_id' => $penundaan_id,
                'tgl_jatuh_tempo' => ($bulan == 12 ) ? $tahun+1 .'-'.$bulan+$i.'-'.'20' : $tahun .'-'.$bulan+$i.'-'.'20',
                'cicilan' => $tunggakan / $jumlah_cicilan ,
                'status' => 'Belum Lunas',
            ]);
        }

        Pencicilan::create([
            'penundaan_id' => $penundaan_id,
            'tgl_jatuh_tempo' => ($bulan == 12 ) ? $tahun+1 .'-'.$bulan+4 . '-'.'20' : $tahun .'-'.$bulan+4 .'-'.'20',
            'cicilan' => $sks ,
            'status' => 'Belum Lunas',
        ]);
    }

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
}
