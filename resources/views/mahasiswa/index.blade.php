@extends('layouts.template')

@section('content')
<h1 class="mt-4">Mahasiswa</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Mahasiswa</li>
</ol>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Jenis Kelas</th>
                        <th>Penundaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($mahasiswa as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->prodi }}</td>
                            <td>{{ $item->jenis_kelas }}</td>
                            <td class="text-center" >
                                @if ($item->penundaan != null)
                                <form action="{{ route('superadmin.penundaan.show',$item->student_id) }}" method="get">
                                    <input type="text" name="tahun_ajaran" id="tahunAjaran" value="{{ $tahun_ajaran->tahun_ajaran }}" hidden>
                                    <input type="text" name="semester" id="semester" value="{{ $tahun_ajaran->semester }}" hidden>
                                    <button type="submit" class="btn btn-success btn-sm" title="Lihat Detail"><i class="fa fa-eye"></i></button>
                                </form>
                                @else
                                <span class="badge text-bg-warning">Tidak ada</span>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
