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
    <p>Tahun Ajaran : {{ $tahunajaran->tahun_ajaran }}</p>
    <p>Semester : {{ $tahunajaran->semester }}</p>
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
                                <td>{{ $item->student->nim }}</td>
                                <td>{{ $item->student->user->name }}</td>
                                <td>Rp. {{ number_format( $item->jumlah_tunggakan) }}</td>
                                <td>{{ $item->opsi_penundaan }}</td>
                                <td>{{ $item->tahun_ajaran }}</td>
                                <td>{{ $item->semester }}</td>
                                <td>
                                    @switch($item->status_id)
                                        @case(1)
                                            <span class="badge text bg-secondary">{{ $item->status->name }}</span>
                                            @break
                                        @case(2)
                                            <span class="badge text bg-warning">{{ $item->status->name }}</span>
                                            @break
                                        @case(3)
                                            <span class="badge text bg-primary">{{ $item->status->name }}</span>
                                            @break

                                        @default
                                            <span class="badge text bg-success">{{ $item->status->name }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($item->status_id)
                                        @case(1)
                                            <a target="_blank" href="{{ route('mhs.penundaan.pdf',$item->student->student_id) }}" class="btn btn-secondary m-1 btn-sm">PDF</a>
                                            <form action="{{ route('mhs.penundaan.delete',$item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Yakin akan mengahpus')">Hapus</button>
                                            </form>
                                            @break
                                        @default
                                        <form action="{{ route('mhs.penundaan.show') }}" method="get">
                                            <input type="text" name="tahun_ajaran" id="tahunAjaran" value="{{ $item->tahun_ajaran }}" hidden>
                                            <input type="text" name="semester" id="semester" value="{{ $item->semester }}" hidden>
                                            <button type="submit" class="btn btn-sm btn-success">Detail</button>
                                        </form>
                                        {{-- <a href="{{ route('mhs.penundaan.show',$item->student_id) }}" class="btn btn-success btn-sm"><i class="fa fa-info-circle"></i> Detail</a> --}}

                                    @endswitch
                                    @if ($item->status_id == 1)

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
