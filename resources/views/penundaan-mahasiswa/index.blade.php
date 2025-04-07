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

    @if ($dokumen == null)
    <div class="mb-3 d-flex flex-col">
        <a href="{{ route('mhs.penundaan.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Buat Baru</a>
    </div>

    @else

    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
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

    <div class="card mb-3 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jatuh Tempo</th>
                            <th scope="col">Jumlah Cicilan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Pelunasan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dokumen->cicilan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tgl_jatuh_tempo }}</td>
                                <td>Rp. {{ number_format($item->cicilan) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->tgl_pembayaran }}</td>
                                <td>
                                    @if ($dokumen->status_id == 4)
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editModal('{{ $item->id }}','{{ $item->tgl_jatuh_tempo }}','{{ $item->cicilan }}')" class="btn btn-sm btn-success">Ajukan Perubahan</a>
                                    @else
                                        <a href="#" class="btn btn-sm btn-success disabled">Ajukan Perubahan</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="#" method="post">
                @csrf
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="number" name="id" id="idCicilan" hidden>
                    <div class="row mb-3">
                        <label for="TglJatuhTempo" class="col-form-label col-md-2">Tanggal Kesanggupan</label>
                        <div class="col md-4">
                            <div class="form-floating">
                                <input type="date" name="tgl_jatuh_tempo" id="TglJatuhTempo" placeholder="Tanggal" required class="form-control">
                                <label for="TglJatuhTempo">Tanggal Kesanggupan</label>
                            </div>
                        </div>
                        <label for="perubahanCicilan" class="col-form-label col-md-2">Perubahan Jumlah Cicilan</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" name="cicilan" id="perubahanCicilan" placeholder="Rp. xxxxx" required class="form-control">
                                <label for="perubahanCicilan">Perubahan Jumlah Cicilan</label>
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
        function editModal(id, tgl_jatuh_tempo, cicilan)
        {
            document.getElementById("idCicilan").value = id;
            document.getElementById("TglJatuhTempo").value = tgl_jatuh_tempo;
            document.getElementById("perubahanCicilan").value = cicilan;
        }
    </script>


    @endif



@endsection
