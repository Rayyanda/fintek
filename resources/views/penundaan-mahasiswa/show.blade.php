@extends('layouts.template')

@section('content')
<h1 class="mt-4">Penundaan</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('mhs.penundaan.index') }}">Penundaan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>

<div class="card shadow mb-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Jumlah Tunggakan</th>
                        <th scope="col">Opsi Penundaan</th>
                        <th scope="col">Tahun Ajaran</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $dokumen->student->nim }}</td>
                        <td>{{ $dokumen->student->user->name }}</td>
                        <td>Rp. {{ number_format( $dokumen->jumlah_tunggakan) }}</td>
                        <td>{{ $dokumen->opsi_penundaan }}</td>
                        <td>{{ $dokumen->tahun_ajaran }}</td>
                        <td>{{ $dokumen->semester }}</td>
                        <td>{{ $dokumen->status->name }}</td>
                        <td>
                            @if ($dokumen->status_id == 1)
                            <a target="_blank" href="{{ route('mhs.penundaan.pdf',$dokumen->student->student_id) }}" class="btn btn-secondary m-1 btn-sm">PDF</a>
                            <form action="{{ route('mhs.penundaan.delete',$dokumen->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Yakin akan mengahpus')">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="mb-0">Keterangan Opsi</p>
        <ul>
            <li>Opsi 1 : <span class="text-secondary">(BPP + SKS (20) + Tagihan Sebelumnya) / 5</span></li>
            <li>Opsi 2 : <span class="text-secondary">(BPP + Tagihan Sebelumnya) / 3</span></li>
        </ul>
    </div>
</div>

<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jatuh Tempo</th>
                        <th scope="col">Jumlah Cicilan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Pelunasan</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @php
                        $today = date('Y-m-d');
                    @endphp
                    @foreach ($dokumen->cicilan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tgl_jatuh_tempo }}</td>
                            <td>Rp. {{ number_format($item->cicilan) }}</td>
                            <td>
                                @if ($item->status === 'Lunas')
                                <span class="badge text-bg-success">{{ $item->status }}</span>
                                @else

                                <span class="badge text-bg-warning">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>{{ $item->tgl_pembayaran }}</td>
                            <td>
                                @if ($item->bukti)
                                <a href="#" data-bs-target="#buktiPembayaran"
                                data-bs-toggle="modal"
                                onclick="showBukti('{{ asset('storage/public/images/keuangan/pelunasan/'.$item->bukti) }}')">
                                <i class="fa fa-eye"></i>
                                </a>
                                @endif
                            </td>
                            <td>
                                @if ($dokumen->status_id == 4)
                                    @if ($item->tgl_jatuh_tempo >= $today)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editModal('{{ $item->id }}','{{ $item->tgl_jatuh_tempo }}','{{ $item->cicilan }}')" class="btn btn-sm btn-success">Ajukan Perubahan</a>
                                    @endif
                                    @if ($item->status != 'Lunas')
                                    <a href="#" onclick="bayar('{{ $item->id }}')" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBayar" title="Upload Bukti Bayar" >Bayar</a>
                                    @endif
                                @else
                                    <a href="#" class="btn btn-sm btn-success disabled">Ajukan Perubahan</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3 shadow">
    <div class="card-header">Pengajuan Perubahan</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Cicilan</th>
                        <th scope="col">Jatuh Tempo</th>
                        <th scope="col">Tanggal Baru Diajukan</th>
                        <th scope="col">Jumlah Cicilan Awal</th>
                        <th scope="col">Jumlah Cicilan Terbaru</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($dokumen->cicilans as $item)
                        @if ($item->perubahan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->tgl_jatuh_tempo }}</td>
                            <td>{{ $item->perubahan->tgl_jatuh_tempo }}</td>
                            <td>Rp. {{ number_format($item->cicilan) }}</td>
                            <td>Rp. {{ number_format($item->perubahan->cicilan) }}</td>
                            <td>
                                @if ($item->perubahan->status === 'Disetujui')
                                <span class="badge text-bg-success">{{ $item->perubahan->status }}</span>
                                @else

                                <span class="badge text-bg-warning">{{ $item->perubahan->status }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($item->perubahan->status !== 'Diproses')
                                <form action="{{ route('mhs.perubahan-cicilan.delete',$item->perubahan->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan ajuan perubahan cicilan ini?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>

                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('mhs.perubahan-cicilan.store') }}" method="post">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editModalLabel">Pengajuan Perubahan Cicilan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" name="id" id="idCicilan" hidden>
                <div class="row mb-3">
                    <label for="TglJatuhTempo" class="col-form-label col-md-2">Tanggal Kesanggupan</label>
                    <div class="col md-4">
                        <div class="form-floating">
                            <input type="date" name="tgl_jatuh_tempo" id="TglJatuhTempo" placeholder="Tanggal" required class="form-control">
                            <label for="TglJatuhTempo">Tanggal Kesanggupan</label>
                        </div>
                    </div>
                    <label for="perubahanCicilan" class="col-form-label col-md-2">Perubahan Jumlah Cicilan</label>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" name="cicilan" id="perubahanCicilan" placeholder="Rp. xxxxx" required class="form-control">
                            <label for="perubahanCicilan">Perubahan Jumlah Cicilan</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('mhs.penundaan.pay',$dokumen->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalBayarLabel">Bayar</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" name="id" id="idCicilans" hidden>
                <div class="row mb-3 align-items-center">
                    <label for="buktiBayar" class="col-form-label col-md-2">Bukti Pembayaran</label>
                    <div class="col-md-10">
                        <input type="file" name="bukti" class="form-control" required id="buktiBayar">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="buktiPembayaran" tabindex="-1" aria-labelledby="buktiPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="buktiPembayaranLabel">Bukti Pembayaran</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" id="showBukti" class="img-fluid" width="250" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script>
    function editModal(id, tgl_jatuh_tempo, cicilan)
    {
        document.getElementById("idCicilan").value = id;
        document.getElementById("TglJatuhTempo").value = tgl_jatuh_tempo;
        document.getElementById("perubahanCicilan").value = cicilan;
    }

    function bayar(id)
    {
        document.getElementById('idCicilans').value = id;
    }
    function showBukti(url)
    {
        const bkt = document.getElementById('showBukti');
        bkt.src = url;
    }
    document.getElementById('TglJatuhTempo').addEventListener('change',function(){
        const tanggal = document.getElementById('TglJatuhTempo').value;
        const hari = new Date(tanggal).getDay();
        const bulan = new Date(tanggal).getMonth();
        const tahun = new Date(tanggal).getFullYear();

        //harus di bulan dan tahun yang sama
        if(tahun === tahun && bulan === bulan)
        {

        }
    });
</script>
@endsection
