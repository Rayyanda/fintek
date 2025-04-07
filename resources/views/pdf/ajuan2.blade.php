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
            padding: 20px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
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
            margin: 20px 0;
            text-decoration: underline;
        }
        .content {
            font-size: 12px;
        }
        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            width: 45%;
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
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            /* border: 1px solid black; */
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .note {
            font-size: 10px;
            margin-top: 5px;
            font-style: italic;
        }
        .header-image {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
    <!-- Ganti dengan path gambar header yang sesuai -->
    <img src="{{ asset('images/logo.jpg') }}" alt="Header Universitas Darma Persada" class="header-image">
    <!-- Jika tidak ada gambar, gunakan teks header -->
    <div class="header" >
        <div class="university-name">UNIVERSITAS DARMA PERSADA</div>
        <div class="university-address">
            Jl. Radin Inten II (Terusan casablanca) Pondok Kelapa – Jakarta 13450<br>
            Telp. (021) 8649051, 8649053, 8649057 Fax. (021) 8649052<br>
            E-mail : humas@unsada.ac.id Home page : http://www.unsada.ac.id
        </div>
    </div>

    <div class="document-title">SURAT PERJANJIAN PENUNDAAN PEMBAYARAN BIAYA KULIAH</div>

    <div class="content">
        Yang bertanda tangan di bawah ini saya :<br><br>

        <table>
            <tbody>
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
            </tbody>
        </table>

        <p>Mengajukan permohonan penundaan pembayaran biaya kuliah sebesar,</p>

        <table>
            <tbody>
                <tr>
                    <td>Jumlah Tunggakan</td>
                    <td>:</td>
                    <td>{{ $penundaans->jumlah_tunggakan }}</td>
                </tr>
                <tr>
                    <td>Jumlah yang dibayarkan</td>
                    <td>:</td>
                    <td>
                        <ol>
                            @foreach ($penundaans->cicilan as $item)
                            <li>Jumlah Pembayaran Rp. {{ number_format($item->cicilan) }} pada tanggal {{ $item->tgl_jatuh_tempo }}</li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Permohonan tersebut kami ajukan dengan alasan :</p>
        <p>{{ $penundaans->alasan }}</p>

        <p>Apabila sampai dengan tanggal tersebut tidak menepati janji dan tidak melunasi pembayaran, bersedia dikenakan sanksi administrasi dan akademik yang berlaku di lingkungan Universitas Darma Persada.</p>

        <div class="signature-container">
            <div class="signature-box">
                Jakarta, ...................... 20......<br><br>
                Pemberi Rekomendasi<br>
                Wakil Dekan II<br><br>
                <div class="signature-line"></div>
                <p>Dr. Linda Nur Affa, ST., MT</p>
            </div>
            <div class="signature-box">
                Orang Tua / Wali<br><br>
                Mengajukan<br>
                Rp. 10.000<br><br>
                <div class="signature-line"></div>
                <p>Nama Lengkap</p>
            </div>
        </div>

        <div class="signature-container">
            <div class="signature-box">
                <!-- Kolom kosong untuk sejajarkan -->
            </div>
            <div class="signature-box">
                Menyetujui,<br>
                Wakil Rektor II<br><br>
                <div class="signature-line"></div>
                <p>Nama Lengkap</p>
            </div>
        </div>

        <p class="note">*Melampiri Rincian List Keuangan Mahasiswa</p>
    </div>
</body>
</html>
