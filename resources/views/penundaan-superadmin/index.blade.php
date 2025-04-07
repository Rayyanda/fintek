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
    <div class="card shadow mb-3">
        <div class="card-body">

            <form action="{{ route('superadmin.penundaan.filter') }}" method="GET">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-2">
                        <div class="form-floating">
                            @php
                                $id = $_GET['status_id'] ?? 1;
                            @endphp
                            <select name="status_id" id="status" class="form-control form-control-sm">
                                @foreach ($status as $item)
                                    <option value="{{ $item->id }}" {{ isset($status_id) ? ($item->id == $id ? 'selected' : '') : '' }} >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="status">Filter by Status</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
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
                    <tbody class="table-group-divider" >
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($penundaans as $dokumen)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $dokumen->student->nim }}</td>
                            <td>{{ $dokumen->student->user->name }}</td>
                            <td>Rp. {{ number_format( $dokumen->jumlah_tunggakan) }}</td>
                            <td>{{ $dokumen->opsi_penundaan }}</td>
                            <td>{{ $dokumen->tahun_ajaran }}</td>
                            <td>{{ $dokumen->semester }}</td>
                            <td>{{ $dokumen->status->name }}</td>
                            <td>
                                @if ($dokumen->status_id !== 4)
                                <a title="Update Status" href="#" data-bs-toggle="modal" onclick="loadData('{{ $dokumen->id }}','{{ $dokumen->student->nim }}','{{ $dokumen->student->user->name }}','{{ $dokumen->status_id }}')" data-bs-target="#editModal" class="btn btn-success"><i class="fa fa-pencil-alt"></i></a>
                                @else
                                <a href="{{ route('superadmin.penundaan.show', $dokumen->student->student_id) }}" class="btn btn-primary" title="Detail" ><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                @endif
                            </td>
                            @php
                                $count++;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $penundaans->links() }}
            </div>
            <p class="mb-0">Keterangan Opsi</p>
            <ul>
                <li>Opsi 1 : <span class="text-secondary">(BPP + SKS (20) + Tagihan Sebelumnya) / 5</span></li>
                <li>Opsi 2 : <span class="text-secondary">(BPP + Tagihan Sebelumnya) / 3</span></li>
            </ul>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('superadmin.penundaan.upd_status') }}" method="post">
                @csrf
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editModalLabel">Update Status</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="number" hidden name="id" id="idDokumen">
                    <input type="text" name="nim" id="nimMahasiswa" hidden class="form-control">
                    <div class="row mb-3 align-items-center">
                        <label for="nama" class="col-form-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <input type="text" name="name" id="nama" class="form-control">
                                <label for="nama">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="status" class="col-form-label col-md-2">Status</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <select name="status_id" id="status" class="form-control" >
                                    @foreach ($status as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
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
      <script>
        function loadData(id,nim, nama, status_id)
        {
            document.getElementById('idDokumen').value = id;
            document.getElementById('nimMahasiswa').value = nim;
            document.getElementById('nama').value = nama;
            document.getElementById('status').value = status_id;
        }
      </script>
@endsection
