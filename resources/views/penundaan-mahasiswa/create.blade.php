@extends('layouts.template')

@section('content')
    <h1 class="mt-4">{{ __('Pengajuan Penundaan') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('mhs.penundaan.index') }}">{{ __('Pengajuan Penundaan') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ol>
    @php
    $user = auth()->user()->student;
    @endphp
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow mb-3">
        <form action="{{ route('mhs.penundaan.store') }}" method="post">
            @csrf
            <div class="card-body p-3">
                <h3 class="mb-2">Data Orang Tua / Wali</h3>
                <div class="row mb-3 align-items-center">
                    <label for="namaWali" class="col-md-2">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="text" name="nama_wali" value="{{ $user->nama_wali }}" id="namaWali" placeholder="Nama Wali" autofocus required class="form-control @error('nama_wali') is-invalid @enderror">
                            <label for="namaWali">{{ __('Nama Orang Tua/Wali') }}</label>
                        </div>
                        @error('nama_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <label for="telpWali" class="col-form-label col-md-2">Telepon Rumah / HP <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" name="telp_wali" value="{{ $user->telp_wali }}" id="telpWali" placeholder="0812 xxxx" required class="form-control @error('telp_wali') is-invalid @enderror">
                            <label for="telpWali">{{ __('Telepon Rumah/HP') }}</label>
                        </div>
                        @error('telp_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="alamatRumah" class="col-md-2 col-form-label">Alamat Rumah <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <textarea name="alamat_rumah" id="alamatRumah" class="form-control" placeholder="Alamat Rumah">{{ $user->alamat_rumah }}</textarea>
                            <label for="alamatRumah">{{ __('Alamat Rumah') }}</label>
                        </div>
                        @error('alamat_rumah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="pekerjaanWali" class="col-md-2 col-form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <input type="text" placeholder="Pekerjaan" value="{{ $user->pekerjaan_wali }}" name="pekerjaan_wali" id="pekerjaanWali" required class="form-control @error('pekerjaan_wali') is-invalid @enderror">
                            <label for="pekerjaanWali">{{ __('Pekerjaan') }}</label>
                        </div>
                    </div>
                    <label for="jabatanWali" class="col-md-2 col-form-label">Jabatan <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" placeholder="Jabatan" name="jabatan" value="{{ $user->jabatan }}" id="jabatanWali" required class="form-control @error('jabatan') is-invalid @enderror">
                            <label for="jabatanWali">{{ __('Jabatan') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="alamatKantor" class="col-md-2 col-form-label">Alamat Kantor <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <textarea name="alamat_kantor" id="alamatKantor" class="form-control" placeholder="Alamat Kantor">{{ $user->alamat_kantor }}</textarea>
                            <label for="alamatKantor">{{ __('Alamat Kantor') }}</label>
                        </div>
                        @error('alamat_kantor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <h3 class="mb-2">Data Mahasiswa</h3>

                <div class="row mb-3">
                    <label for="mhsNim" class="col-form-label col-md-2">NIM</label>
                    <div class="col-md-4">
                        <input type="text" name="nim" id="mhsNim" disabled value="{{ $user->nim }}" class="form-control @error('nim') is-invalid @enderror" >
                        @error('semester')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label for="noTelp" class="col-md-2 col-form-label">{{ __('Phone Number') }}</label>
                    <div class="col-md-4">
                        <input type="text" name="no_telp" id="noTelp" value="{{$user->no_telp }}" class="form-control">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fakultasLabel" class="col-md-2 col-form-label">{{ __('Faculty') }}</label>
                    <div class="col-md-4">
                        <select class="form-select" name="fakultas">
                            <option selected value="Teknik">Teknik</option>
                        </select>
                    </div>
                    <label for="prodiLabel" class="col-md-2 col-form-label">Majority</label>
                    <div class="col-md-4">
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi">
                            <option {{ $user->prodi == 'Sistem Informasi' ? 'selected' : '' }} value="Sistem Informasi">Sistem Informasi</option>
                            <option {{ $user->prodi == 'Teknologi Informasi' ? 'selected' : '' }} value="Teknologi Informasi">Teknologi Informasi</option>
                            <option {{ $user->prodi == 'Teknik Mesin' ? 'selected' : '' }} value="Teknik Mesin">Teknik Mesin</option>
                            <option {{ $user->prodi == 'Teknik Industri' ? 'selected' : '' }} value="Teknik Industri">Teknik Industri</option>
                            <option {{ $user->prodi == 'Teknik Elektro' ? 'selected' : '' }} value="Teknik Elektro">Teknik Elektro</option>
                        </select>
                        @error('prodi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="semester" class="col-form-label col-md-2">Semester</label>
                    <div class="col-md-4">
                        <input type="number" name="semester" value="{{ $user->semester }}" id="semester" required class="form-control @error('semester') is--invalid @enderror">
                        @error('semester')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label for="gpa" class="col-form-label col-md-2">IPK</label>
                    <div class="col-md-4">
                        <input type="text"  name="ipk" value="{{ $user->ipk }}" id="gpa" required class="form-control @error('ipk') is-invalid @enderror">
                        @error('ipk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="alamat" class="col-form-label col-md-2">{{ __('Address') }}</label>
                    <div class="col-md-10">
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" required>{{ $user->alamat }}</textarea>
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="alamatKantor" class="col-form-label col-md-2">{{ __('Office Address') }}</label>
                    <div class="col-md-6">
                        <textarea class="form-control @error('alamat_kantor') is-invalid @enderror" name="alamat_kantor" id="alamatKantor">{{ $user->alamat_kantor }}</textarea>
                        @error('alamat_kantor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label for="jenisKelas" class="col-form-label col-md-2">{{ __('Class Type') }}</label>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <select class="form-select" name="jenis_kelas" id="jenisKelas">
                                <option value="Pagi" {{ $user->jenis_kelas == 'Pagi' ? 'selected' : ''}} >Reguler Pagi</option>
                                <option value="Malam" {{ $user->jenis_kelas == 'Malam' ? 'selected' : ''}} >Reguler Malam</option>
                            </select>
                            <label for="jenisKelas">{{ __('Class Type') }}</label>
                        </div>
                    </div>
                </div>
                <hr>
                <h3 class="mb-2">Data Tagihan</h3>
                <div class="row mb-3 align-items-center">
                    <label for="jmlTunggakan" class="col-form-label col-md-2">Jumlah Tunggakan <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <input type="number" name="jumlah_tunggakan" value="{{ old('jumlah_tunggakan') }}" placeholder="Tunggakan" id="jmlTunggakan" required class="form-control @error('jumlah_tunggakan') is-invalid @enderror">
                            <label for="jmlTunggakan">Jumlah Tunggakan</label>
                        </div>
                        @error('jumlah_tunggakan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <label for="alasana" class="col-md-2 col-form-label">Alasan Penunggakan <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <textarea name="alasan" placeholder="Alasan Penunggakan" id="alasana" class="form-control @error('alasan') is-invalid @enderror">{{ old('alasan') }}</textarea>
                            <label for="alasana">Alasan Penunggakan</label>
                        </div>
                        @error('alasan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                {{-- <div class="row mb-3 align-items-center">
                    <label for="buktiTunggakan" class="col-md-2 col-form-label">Bukti Tunggakan <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <input type="file" name="bukti_tunggakan" id="buktiTunggakan" class="form-control @error('bukti_tunggkana') is-invalid @enderror" required>
                            <label for="buktiTunggakan">Bukti Tunggakan</label>
                        </div>
                        @error('bukti_tunggakan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}

                <div class="row mb-3 align-items-center">
                    <label for="tahunAjaran" class="col-form-label col-md-2">Tahun Ajaran <span class="text-danger">*</span></label>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('tahun_ajaran') is-invalid @enderror" id="tahunAjaran" name="tahun_ajaran">
                              <option selected>Pilih Tahun Ajaran</option>
                              <option value="2025/2026">2025/2026</option>
                              <option value="2026/2027">2026/2027</option>
                              <option value="2027/2028">2027/2028</option>
                            </select>
                            <label for="tahunAjaran">Tahun Ajaran</label>
                        </div>
                        @error('tahun_ajaran')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label for="semester" class="col-form-label col-md-2">Semester</label>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('semester') is-invalid @enderror" name="semester" id="semester" required>
                              <option selected>Pilih Semester</option>
                              <option value="Ganjil">Ganjil</option>
                              <option value="Genap">Genap</option>
                            </select>
                            <label for="semester">Semester</label>
                        </div>
                        @error('semester')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="opsiPenundaan" class="col-form-label col-md-2">Opsi Penundaan</label>
                    <div class="col-md-10">
                        <div class="form-floating">
                            <select class="form-select @error('opsi') is-invalid @enderror" name="opsi" id="opsiPenundaan" required>
                              <option selected>Pilih Opsi</option>
                              <option value="1">(BPP + SKS (20) + Tagihan Sebelumnya) / 5</option>
                              <option value="2">(BPP + Tagihan Sebelumnya) / 3</option>
                            </select>
                            <label for="opsiPenundaan">Opsi Penundaan</label>
                        </div>
                        <span class="text-secondary"><i class="fa fa-info-circle"></i>Tagihan sebelumnya bisa berupa jenis tagihan BPP ataupun SKS</span>
                        @error('opsi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
