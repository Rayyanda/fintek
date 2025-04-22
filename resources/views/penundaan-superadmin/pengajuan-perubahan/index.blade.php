@extends('layouts.template')

@section('content')
<h1 class="mt-4">Pengajuan Perubahan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Pengajuan Perubahan</li>
</ol>
<p>Tahun Ajaran : {{ $tahun_ajaran->tahun_ajaran }}</p>
<p>Semester : {{ $tahun_ajaran->semester }}</p>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive p-2">
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
                        <td>{{ \Carbon\Carbon::parse($item->perubahan->tgl_jatuh_tempo)->format('d M Y') }}</td>
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
                            <form action="{{ route('superadmin.penundaan.show',$items->student->student_id) }}" method="get">
                                <input type="text" name="tahun_ajaran" id="tahunAjaran" value="{{ $items->tahun_ajaran }}" hidden>
                                <input type="text" name="semester" id="semester" value="{{ $items->semester }}" hidden>
                                <button type="submit" class="btn btn-primary" title="Lihat Detail"><i class="fa fa-eye"></i></button>
                            </form>
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
