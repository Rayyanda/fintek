@extends('layouts.template')

@section('content')
<h1 class="mt-4">Rencana Kerja dan Anggaran Tahunan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">RKAT</li>
</ol>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="mb-3">
    <a href="#" data-bs-target="#storeDataModal" data-bs-toggle="modal" class="btn btn-primary">Tambah Tahun Anggaran <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
</div>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead class="text-center align-items-middle">
                    <tr>
                        <th rowspan="2" >No</th>
                        <th rowspan="2">Program</th>
                        <th rowspan="2">Tahun Anggaran</th>
                        <th colspan="2">Anggaran</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th>Tercairkan</th>
                        <th>Digunakan</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($rkats as $item)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->program }}</td>
                        <td>{{ $item->tahun_anggaran }}</td>
                        <td>Rp. {{ number_format($item->anggaran_tercairkan) }}</td>
                        <td>Rp. {{ number_format($item->anggaran_terpakai) }}</td>
                        <td>
                            {!! ($item->status == 1)
                                ? '<span class="badge text-bg-success">Berjalan</span>'
                                : '<span class="badge text-bg-danger">Ditutup</span>'
                            !!}
                        </td>
                        <td>
                            @if ($item->status == 1)
                                <a href="{{ route('superadmin.rkat.show',$item->rkat_id) }}" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="storeDataModal" tabindex="-1" aria-labelledby="storeDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('superadmin.rkat.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="storeDataModalLabel">Tambah Tahun Anggaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <label for="tahunAnggaran" class="col-form-label col-md-2">Tahun Anggaran</label>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" name="tahun_anggaran" id="tahunAnggaran" placeholder="2025" required class="form-control">
                                <label for="tahunAnggaran">Tahun Anggaran</label>
                            </div>
                        </div>
                        <label for="namaRkat" class="col-form-label col-md-2">Nama</label>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input type="text" name="nama_rkat" id="namaRkat" placeholder="RKAT Pembaruan" class="form-control">
                                <label for="namaRkat">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="anggaranTercairkan" class="col-form-label col-md-2">Anggaran Tercairkan</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <input type="number" name="anggaran_tercairkan" id="anggaranTercairkan" required class="form-control">
                                <label for="anggaranTercairkan">Anggaran Tercairkan</label>
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

@endsection
