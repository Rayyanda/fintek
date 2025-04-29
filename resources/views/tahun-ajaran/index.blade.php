@extends('layouts.template')

@section('content')
<h1>Tahun Ajaran</h1>
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
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-success">Tambah</a>
</div>

<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th><i>Is Active</i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>
                                @if ($item->is_active === 1)
                                    <span class="badge text-bg-success">Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="d-flex flex-row flex-nowrap">
                                <form action="{{ route('tahunAjaran.delete',$item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                                <form action="{{ route('tahunAjaran.update',$item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tahunAjaran.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Tambahkan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2 align-items-center">
                        <label for="tahunAjaran" class="col-md-2 col-form-label">Tahun Ajaran</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="tahun_ajaran" required id="tahunAjaran" placeholder="Tahun Ajaran" class="form-control">
                                <label for="tahunAjaran">Tahun Ajaran</label>
                            </div>
                        </div>
                        <label for="semester" class="col-md-2 col-form-label">Semester</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" name="semester" id="semester" required>
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
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
