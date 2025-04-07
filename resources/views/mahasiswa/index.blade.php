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
<div class="mb-3">
    <a href="#" data-bs-target="#storeDataModal" data-bs-toggle="modal" class="btn btn-primary">Tambah Data</a>
</div>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                            <td>{{ ($item->penundaan != null ? 'Ada' : 'Tidak Ada') }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $mahasiswa->links() }}
        </div>
    </div>
</div>
@endsection
