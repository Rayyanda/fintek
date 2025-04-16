@extends('layouts.template')

@section('content')
<h1 class="mt-4">Pengajuan Perubahan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Pengajuan Perubahan</li>
</ol>
@php
    $tahunSekarang = date('Y');
    $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);
@endphp
<p>Tahun Ajaran : {{ $tahunAjaran }}</p>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal Baru Diajukan</th>
                        <th scope="col">Jumlah Cicilan Awal</th>
                        <th scope="col">Jumlah Cicilan Terbaru</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($penundaans as $items)
                    @foreach ($items->cicilans as $item)

                    @if ($item->perubahan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $items->student->nim }}</td>
                        <td>{{ $items->student->user->name}}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
