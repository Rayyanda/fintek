<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjanjian Penundaan Pembayaran Biaya Kuliah</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px 15px;
            line-height: 1.5;
        }
        .top{
            display: flex;
            justify-content:start;
            align-items: center;
            flex-flow: row;
            flex-wrap: nowrap;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .university-name {
            font-weight: bold;
            font-size: 16px;
        }
        .university-address {
            font-size: 12px;
        }
        .document-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 5px 0;
            text-decoration: underline;
        }
        .content {
            font-size: 12px;
        }
        div.signature-section {
            /* margin-top: 50px; */
            display: flex;
            flex-flow: row;
            justify-content:space-around;
        }
        .signature-box {
            width: 50%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .table-container {
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
        }
        /* table, th, td {
            border: 1px solid black;
        } */
        th, td {
            padding: 3px 4px;
            line-height:1;  /* Mengurangi tinggi baris */
            font-size: 12px;
            text-align: left;
        }
        .note {
            font-size: 10px;
            margin-top: 5px;
            font-style: italic;
        }
        .mb-0{
            margin-bottom : 0px;
        }
        .m-0{
            margin: 0px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="university-name">UNIVERSITAS DARMA PERSADA</div>
        <div class="university-address">
            Jl. Radin Inten II (Terusan casablanca) Pondok Kelapa – Jakarta 13450<br>
            Telp. (021) 8649051, 8649053, 8649057 Fax. (021) 8649052<br>
            E-mail : humas@unsada.ac.id Home page : http://www.unsada.
        </div>
    </div>

    <div class="document-title">SURAT PERJANJIAN PENUNDAAN PEMBAYARAN BIAYA KULIAH</div>

    <div class="content">
        <table class="m-0" >
            <tbody>
                <tr>
                    <td colspan="3" >Yang bertanda tangan di bawah ini saya :</td>
                </tr>
                <tr>
                    <td>Nama Orang Tua/Wali</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->nama_wali }}</td>
                </tr>
                <tr>
                    <td>Alamat Rumah</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->alamat_rumah }}</td>
                </tr>
                <tr>
                    <td>Telepon Rumah/HP</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->telp_wali }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan/Jabatan</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->pekerjaan_wali }} / {{ $penundaans->student->jabatan }}</td>
                </tr>
                <tr>
                    <td>Alamat Kantor/Telp</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->alamat_kantor_wali }}</td>
                </tr>
                <tr>
                    <td>Nama Mahasiswa</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->user->name }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->nim }}</td>
                </tr>
                <tr>
                    <td>Fakultas/Program Studi</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->fakultas }} / {{ $penundaans->student->prodi }}</td>
                </tr>
                <tr>
                    <td>Semester/IPK</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->semester }} / {{ $penundaans->student->ipk }}</td>
                </tr>
                <tr>
                    <td>Alamat Rumah</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->alamat }}</td>
                </tr>
                <tr>
                    <td>Telepon Rumah/HP</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->no_telp }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan/Jabatan</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->pekerjaan }}</td>
                </tr>
                <tr>
                    <td>Alamat Kantor/Telp</td>
                    <td>:</td>
                    <td>{{ $penundaans->student->alamat_kantor }}</td>
                </tr>
                <tr>
                    <td colspan="3" >Mengajukan permohonan penundaan pembayaran biaya kuliah sebeser,</td>
                </tr>
                <tr>
                    <td>Jumlah Tunggakan</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($penundaans->jumlah_tunggakan) }}</td>
                </tr>
                <tr>
                    <td>Jumlah yang dibayarkan</td>
                    <td>:</td>
                    <td>
                        <ol class="m-0" >
                            @foreach ($penundaans->cicilans as $item)
                            <li>Jumlah Pembayaran Rp. <u>{{ number_format($item->cicilan) }}</u> pada tanggal {{ $item->tgl_jatuh_tempo }}</li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
                <tr>

                </tr>
            </tbody>
        </table>

        <p class="m-0" >Permohonan tersebut kami ajukan dengan alasan :</p>
        <p class="m-0">{{ $penundaans->alasan }}</p>

        <p class="m-0">Apabila sampai dengan tanggal tersebut tidak menepati janji dan tidak melunasi pembayaran, bersedia dikenakan sanksi administrasi dan akademik yang berlaku di lingkungan Universitas Darma Persada.</p>

        <table style="width:100%;" >
            <tbody>
                <tr>
                    <td colspan="3" >Jakarta, ................ 20.....</td>
                </tr>
                <tr>
                    <td>
                        <div class="signature-box">
                            Pemberi Rekomendasi<br>
                            Wakil Dekan II<br><br>
                            <div class="signature-line"></div>
                            <p>Dr. Linda Nur Affa, ST., MT</p>
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="signature-box">
                            Orang Tua / Wali<br>
                            materai <br>
                            Rp. 10.000<br>
                            <div class="signature-line"></div>
                            <p>Nama Lengkap</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="signature-box">
                            Menyetujui,<br>
                            Wakil Rektor II<br><br>
                            <div class="signature-line"></div>
                            <p>Nama Lengkap</p>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
{{--
        <div class="signature-section">


        </div> --}}
    </div>
</body>
</html>
