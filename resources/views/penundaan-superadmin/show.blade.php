@extends('layouts.template')

@section('content')
<h1 class="mt-4">Pengajuan Penundaan</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('superadmin.penundaan.index') }}">Pengajuan Penundaan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ $error }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $penundaan->student->nim }}</td>
                        <td>{{ $penundaan->student->user->name }}</td>
                        <td>Rp. {{ number_format( $penundaan->jumlah_tunggakan) }}</td>
                        <td>{{ $penundaan->opsi_penundaan }}</td>
                        <td>{{ $penundaan->tahun_ajaran }}</td>
                        <td>{{ $penundaan->semester }}</td>
                        <td>{{ $penundaan->status->name }}</td>
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
    <div class="card-header">
        <h5 class="mb-0">Pencicilan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jatuh Tempo</th>
                        <th scope="col">Jumlah Cicilan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Pelunasan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penundaan->cicilans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d M Y') }}</td>
                            <td>Rp. {{ number_format($item->cicilan) }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->tgl_pembayaran }}</td>
                            <td>
                                @if ($item->status != 'Lunas')
                                <a href="#" data-bs-toggle="modal" data-bs-target="#sendNotifModal" title="Kirim pemberitahuan" class="btn btn-primary btn-sm mr-1 mb-1"><i class="fa fa-share" aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-success btn-sm mr-1 mb-1" title="Periksa status"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
                    @foreach ($penundaan->cicilans as $item)
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
                                @if ($item->perubahan->status !== 'Disetujui')
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editStatusAjuanModal"
                                onclick="editModal('{{ $item->id }}','{{ $item->perubahan->tgl_jatuh_tempo }}','{{ $item->perubahan->cicilan }}')"
                                 class="btn btn-success btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                <form action="#" method="post">
                                    @csrf
                                    <input type="number" name="cicilan_id" hidden value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak ajuan ini?')"> <i class="fa fa-trash" aria-hidden="true"></i></button>
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


<div class="modal fade" id="editStatusAjuanModal" tabindex="-1" aria-labelledby="editStatusAjuanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('superadmin.perubahan-cicilan.update') }}" method="post">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editStatusAjuanModalLabel">Edit Cicilan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" name="cicilan_id" id="idCicilan" hidden>
                <h3>Apakah Anda yakin akan mengupdate cicilan ini ?</h3>
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
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="sendNotifModal" tabindex="-1" aria-labelledby="sendNotifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="sendNotifModalLabel">Kirim Pemberitahuan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <label for="namaPenerima" class="col-form-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <input type="text" name="nama_penerima" value="{{ $penundaan->student->user->name }}" class="form-control" id="namaPenerima" placeholder="Nama penerima">
                                <label for="namaPenerima">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="noHpPenerima" class="col-form-label col-md-2">No. HP Mahasiswa</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="no_hp" placeholder="No Hp" id="noHpPenerima" value="{{ $penundaan->student->no_telp }}" class="form-control">
                                <label for="noHpPenerima">No. HP</label>
                            </div>
                        </div>
                        <label for="emailMhs" class="col-form-label col-md-1">Email</label>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input type="email" name="email" id="emailMhs" placeholder="mhs@email.com" value="{{ $penundaan->student->user->email }}" class="form-control">
                                <label for="emailMhs">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="pesan" class="col-form-label col-md-2">Pesan</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <textarea name="pesan" id="pesan" class="form-control" placeholder="Pesan" style="height: 100px"></textarea>
                                <label for="pesan">Pesan</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
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
</script>
@endsection
