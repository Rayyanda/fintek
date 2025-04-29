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

<div class="card shadow mb-3">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Jenis Tagihan</th>
                        <th>Nominal Tagihan</th>
                        <th>Denda</th>
                        <th>Potongan</th>
                        <th>Total</th>
                        <th>Total Bayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <form action="#" method="post">

                    </form>
                    @foreach ($tagihan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->student->nim }}</td>
                            <td>{{ $item->student->user->name }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->jenis_tagihan }}</td>
                            <td>Rp. {{ number_format($item->nominal) }}</td>
                            <td>{{ $item->denda }}</td>
                            <td>{{ $item->potongan }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->terbayar }}</td>
                            <td>{{ $item->sisa }}</td>
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
                                <a href="#"
                                onclick="showUpdateModal('{{ $item->student_id }}','{{ $item->tagihan_id }}','{{ $item->student->user->name }}','{{ $item->student->nim }}')"
                                data-bs-target="#updateModal" data-bs-toggle="modal" class="btn btn-sm btn-success"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.tagihan.update') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModalLabel">Update Tagihan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="student_id" id="studentId" hidden>
                    <input type="text" name="tagihan_id" id="tagihanId" hidden>
                    <div class="row mb-2 align-items-center">
                        <label for="nimMahasiswa" class="col-form-label col-md-2">NIM</label>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" name="nim" id="nimMahasiswa"  class="form-control">
                                <label for="nimMahasiswa">NIM</label>
                            </div>
                        </div>
                        <label for="namaMahasiswa" class="col-form-label col-md-2">Nama</label>
                        <div class="col-md-5">
                            <div class="form-floating">
                                <input type="text" name="name" id="namaMahasiswa"  class="form-control">
                                <label for="namaMahasiswa">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <label for="statusTagihan" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <select name="status" id="statusTagihan" class="form-select">
                                    <option value="Valid">Valid</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function showUpdateModal(student_id, tagihan_id, nama, nim)
        {
            document.getElementById('studentId').value = student_id;
            document.getElementById('tagihanId').value = tagihan_id;
            document.getElementById('nimMahasiswa').value = nim;
            document.getElementById('namaMahasiswa').value = nama;
        }
    </script>

@endsection

@section('script')
@endsection
