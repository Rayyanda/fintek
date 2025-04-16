@extends('layouts.template')

@section('content')
<h1 class="mt-4">Pengajuan Penundaan</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('superadmin.penundaan.index') }}">Pengajuan Penundaan</a></li>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $student->nim }}</td>
                        <td>{{ $student->user->name }}</td>
                        <td>Rp. {{ number_format( $student->penundaan->jumlah_tunggakan) }}</td>
                        <td>{{ $student->penundaan->opsi_penundaan }}</td>
                        <td>{{ $student->penundaan->tahun_ajaran }}</td>
                        <td>{{ $student->penundaan->semester }}</td>
                        <td>{{ $student->penundaan->status->name }}</td>
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
                    @foreach ($student->penundaan->cicilans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tgl_jatuh_tempo }}</td>
                            <td>Rp. {{ number_format($item->cicilan) }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->tgl_pembayaran }}</td>
                            <td>
                                @if ($item->status != 'Lunas')
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
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
                    @foreach ($student->penundaan->cicilans as $item)
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
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
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


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="#" method="post">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Cicilan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
