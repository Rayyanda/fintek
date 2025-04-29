@extends('layouts.template')

@section('content')
<h1 class="mt-4">Rencana Kerja dan Anggaran Tahunan</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('superadmin.rkat.index') }}">RKAT</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $rkat->tahun_anggaran }}</li>
    </ol>
</nav>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ $error }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="mb-3">
    <a href="#" data-bs-target="#storeDataModal" data-bs-toggle="modal" class="btn btn-primary m-1"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Rincian Penggunaan</a>
    <a href="#" class="btn btn-secondary m-1">Cetak PDF</a>
</div>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th scope="row">Tahun Anggaran</th>
                        <td>:</td>
                        <td>{{ $rkat->tahun_anggaran }}</td>
                        <th scope="row" >Status</th>
                        <td>:</td>
                        <td>
                            {!! ($rkat->status == 1)
                                ? '<span class="badge text-bg-success">Berjalan</span>'
                                : '<span class="badge text-bg-danger">Ditutup</span>'
                            !!}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" >Anggaran Tercairkan</th>
                        <td>:</td>
                        <td>Rp. {{ number_format($rkat->anggaran_tercairkan) }}</td>
                        <th scope="row" >Anggaran Belanja</th>
                        <td>:</td>
                        <td>Rp. {{ number_format($rkat->anggaran_belanja)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card mb-3 shadow">
    <div class="card-header bg-primary text-white">Rincian Anggaran</div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Peruntukkan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Total</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Status</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rkat->detail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->peruntukkan }}</td>
                            <td>Rp. {{ number_format($item->harga) }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>Rp. {{ number_format($item->total) }}</td>
                            <td>
                                @if ($item->bukti_penggunaan)
                                <a href="#" data-bs-target="#buktiPenggunaan"
                                    data-bs-toggle="modal"
                                    onclick="showBukti('{{ asset('storage/public/images/keuangan/rkat/'.$rkat->tahun_anggaran.'/'.$item->bukti_penggunaan) }}')">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                    @endif
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="storeDataModal" tabindex="-1" aria-labelledby="storeDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('superadmin.rkat.detail.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="rkat_id" value="{{ $rkat->rkat_id }}" hidden id="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="storeDataModalLabel">Tambah Rincian Anggaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <label for="tglPenggunaan" class="col-form-label col-md-2">Tanggal</label>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" name="tanggal" min="01-01-2026" id="tglPenggunaan" placeholder="11/04/2025" required class="form-control">
                                <label for="tglPenggunaan">Tanggal</label>
                            </div>
                            <span class="text-danger" id="tglPenggunaanInfo"></span>
                        </div>
                        <label for="peruntukkanRkat" class="col-form-label col-md-1">Peruntukkan</label>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="peruntukkan" id="peruntukkanRkat" placeholder="Perbaikan" class="form-control">
                                <label for="peruntukkanRkat">Peruntukkan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="harga" class="col-form-label col-md-2">Harga</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" name="harga" placeholder="Rp. 1.000.000" id="harga" required class="form-control">
                                <label for="harga">Harga</label>
                            </div>
                        </div>
                        <label for="jumlah" class="col-form-label col-md-1">Jumlah</label>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="number" name="jumlah" placeholder="20" id="jumlah" required class="form-control">
                                <label for="jumlah">Jumlah</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select name="satuan" required class="form-control" id="satuan">
                                    <option value="">Pilih Satuan</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Biji">Biji</option>
                                </select>
                                <label for="satuan">Satuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <label for="bukti" class="col-form-label col-md-2">Bukti Penggunaan</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="file" name="bukti_penggunaan" id="bukti" class="form-control">
                                <label for="bukti">Bukti Penggunaan</label>
                            </div>
                        </div>
                        <label for="status" class="col-form-label col-md-2">Status</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="status" required class="form-control" id="status">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Diproses">Belum Diproses</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="keterangan" class="col-form-label col-md-2">Keterangan</label>
                        <div class="col-md-10">
                            <div class="form-floating">
                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                <label for="keterangan">Keterangan</label>
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

<!-- Modal -->
<div class="modal fade" id="buktiPenggunaan" tabindex="-1" aria-labelledby="buktiPenggunaanLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="buktiPenggunaanLabel">Bukti Penggunaan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" id="showBukti" class="img-fluid" width="250" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
    <script>
        document.getElementById('tglPenggunaan').addEventListener('change', function () {
            const input = document.getElementById('tglPenggunaan');
            const tanggal = input.value;
            const tahun = new Date(tanggal).getFullYear();
            //console.log(tahun);
            const peringatan = document.getElementById('tglPenggunaanInfo');

            // Batas tahun


            if (tahun !== {{ $rkat->tahun_anggaran }}) {
                peringatan.textContent = `Tanggal harus dalam tahun {{ $rkat->tahun_anggaran }}`;
                input.value = ''; // Kosongkan input jika tidak valid
                input.classList.add('is-invalid')
            } else {
                input.classList.remove(['is-invalid']);
                peringatan.textContent = ''; // Kosongkan pesan jika valid
            }
        });
        function showBukti(url)
        {
            const bkt = document.getElementById('showBukti');
            bkt.src = url;
        }
    </script>
@endsection
