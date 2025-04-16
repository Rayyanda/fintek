@extends('layouts.template')

@section('content')
    <h1 class="mt-4">Pengajuan Penundaan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pengajuan Penundaan</li>
    </ol>
    @php
        $tahunSekarang = date('Y');
        $tahunAjaran = $tahunSekarang . '/' . ($tahunSekarang + 1);
    @endphp
    <p>Tahun Ajaran : {{ $tahunAjaran }}</p>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}.
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

    <div class="mb-3 d-flex flex-col">
        <a href="{{ route('mhs.penundaan.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Buat Baru</a>
    </div>
    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table">
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
                        @foreach ($dokumen as $item)
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
                        @endforeach
                        {{-- <tr>
                        </tr> --}}
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
@endsection
