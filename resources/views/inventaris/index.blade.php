@extends('layouts.template')

@section('content')
<h1 class="mt-4">Inventaris</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Inventaris</li>
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
<div class="card mb-3 shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Stok</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" >
                    @foreach ($inventaris as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->jumlah_barang }}</td>
                            <td class="d-flex flex-row" >
                                <a href="#" class="btn btn-success btn-sm mr-1 mb-1"><i class="fa fa-pencil-alt"></i></a>
                                <form action="{{ route('inventaris.delete') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="number" hidden name="id_inv" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm mr-1 mb-1"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $inventaris->links() }}
        </div>
    </div>
</div>
<div class="modal fade" id="storeDataModal" tabindex="-1" aria-labelledby="storeDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('inventaris.store') }}" method="post">
            @csrf
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="storeDataModalLabel">Tambah Data</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2 align-items-center">
                    <label for="namaBarang" class="col-md-2 col-form-label">Nama Barang</label>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" placeholder="Nama Barang" name="nama_barang" id="namaBarang" required class="form-control form-control-sm">
                            <label for="namaBarang">Nama Barang</label>
                        </div>
                    </div>
                    <label for="jmlBarang" class="col-form-label col-md-2">Jumlah Barang</label>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" placeholder="Jumlah" name="jumlah_barang" id="jmlBarang" required class="form-control form-control-sm">
                            <label for="jmlBarang">Jumlah Barang</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2 align-items-center">
                    <label for="lokasiBarang" class="col-form-label col-md-2">Lokasi</label>
                    <div class="col-md-7">
                        <div class="form-floating">
                            <textarea name="lokasi" id="lokasiBarang" placeholder="Lokasi" class="form-control form-control-sm"></textarea>
                            <label for="lokasiBarang">Lokasi</label>
                        </div>
                    </div>
                    <label for="statusInv" class="col-form-label col-md-1">Status</label>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <select name="status" class="form-control form-control-sm" id="status">
                                <option value="tersedia">Tersedia</option>
                                <option value="tidak tersedia">Tidak Tersedia</option>
                            </select>
                            <label for="status">Status</label>
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
