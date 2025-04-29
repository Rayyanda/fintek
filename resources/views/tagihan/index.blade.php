@extends('layouts.template')

@section('content')
<h1 class="mt-4">Tagihan</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      {{-- <li class="breadcrumb-item"><a href="{{ route('superadmin.rkat.index') }}">RKAT</a></li> --}}
      <li class="breadcrumb-item active" aria-current="page">Tagihan Anda</li>
    </ol>
</nav>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3">
    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTagihanModal">Baru</a>
</div>

<div class="card shadow mb-3">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Jenis Tagihan</th>
                        <th>Nominal Tagihan</th>
                        <th>Denda</th>
                        <th>Potongan</th>
                        <th>Total Bayar</th>
                        <th>Sisa</th>
                        <th>Penundaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($tagihan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->student->user->name }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->jenis_tagihan }}</td>
                            <td>Rp. {{ number_format($item->nominal) }}</td>
                            <td>{{ $item->denda }}</td>
                            <td>{{ $item->potongan }}</td>
                            <td>{{ $item->terbayar }}</td>
                            <td>{{ $item->sisa }}</td>
                            <td>
                                @if ($item->tagihans != null)
                                <a href="{{ route('mhs.penundaan.index') }}" class="btn btn-success btn-sm"><i class="fa fa-info-circle"></i> Detail</a>
                                @else
                                <span class="badge text-bg-warning">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                @switch($item->status)
                                    @case('Valid')
                                        <span class="badge text-bg-primary">{{ $item->status }}</span>
                                        @break
                                    @case('Lunas')
                                        <span class="badge text-bg-success">{{ $item->status }}</span>
                                        @break
                                    @case('Penundaan')
                                        <span class="badge text-bg-warning">{{ $item->status }}</span>
                                        @break
                                    @default
                                        <span class="badge text-bg-secondary">{{ $item->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @switch($item->status)
                                            {{-- @case('Valid')
                                                <span class="badge text-bg-primary">{{ $item->status }}</span>
                                                @break
                                            @case('Lunas')
                                                <span class="badge text-bg-success">{{ $item->status }}</span>
                                                @break --}}
                                            @case('Penundaan')
                                                <span class="badge text-bg-warning">{{ $item->status }}</span>
                                                @break
                                            @case('Belum Lunas')
                                                <li>
                                                    <a href="https://newportal.unsada.ac.id/siakad/list_tagihanmhs" target="_blank" class="dropdown-item" title="Bayar">Bayar</a>
                                                </li>
                                                @if ($item->tagihans == null)
                                                <li>
                                                    <a href="{{ route('mhs.penundaan.create',$item->tagihan_id) }}" class="dropdown-item" title="Penundaan">Ajukan Penundaan</a>
                                                </li>
                                                @endif
                                                @break

                                            @default
                                                <li>
                                                    <a href="#" onclick="alert('Tunggu proses validasi oleh Admin')" class="dropdown-item" title="Penundaan">Ajukan Penundaan</a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="alert('Tunggu proses validasi oleh Admin')"  class="dropdown-item" title="Bayar">Bayar</a>
                                                </li>


                                        @endswitch
                                      {{-- <li><a class="dropdown-item" href="#">Menu item</a></li>
                                      <li><a class="dropdown-item" href="#">Menu item</a></li>
                                      <li><a class="dropdown-item" href="#">Menu item</a></li> --}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addTagihanModal" tabindex="-1" aria-labelledby="addTagihanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('mhs.tagihan.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTagihanModalLabel">Masukkan Tagihan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2 align-items-center">
                        <label for="totalTagihan" class="col-md-2 col-form-label">Total Tagihan</label>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" placeholder="Rp. 7.500.000" name="nominal" required id="totalTagihan" class="form-control">
                                <label for="totalTagihan">Total Tagihan</label>
                            </div>
                        </div>
                        <label for="jenisTagihan" class="col-form-label col-md-1">Jenis Tagihan</label>
                        <div class="col-md-3">
                            <input type="text" name="jenis_tagihan" placeholder="BPP / SKS / Lainnya" required id="jenisTagihan" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <label for="tahunAjaran" class="col-form-label col-md-2">Tahun Ajaran</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="tahun_ajaran" class="form-control" required id="tahunAjaran">
                                    @for ($i = 2024; $i <= 2029; $i++)
                                        <option value="{{ $i }}/{{ $i+1 }}">{{ $i }}/{{ $i+1 }}</option>
                                    @endfor
                                </select>
                                <label for="tahunAjaran">Tahun Ajaran</label>
                            </div>
                        </div>
                        <label for="semester" class="col-form-label col-md-2">Semester</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="semester" class="form-control" required id="semester">
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <label for="semester">Semester</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
