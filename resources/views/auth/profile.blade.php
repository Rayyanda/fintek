@extends('layouts.template')

@section('content')
    <h1 class="mt-4">{{ __('My Profile') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">{{ __('My Profile') }}</li>
    </ol>
    <div class="card shadow mb-3">
        <div class="card-body">
            <form enctype="multipart/form-data" method="POST" >
                <div class="row mb-3">
                    <label for="username" class="col-form-label col-md-2">Name</label>
                    <div class="col-md-4">
                        <input type="text" name="name" id="username" value="{{ auth()->user()->name }}" class="form-control">
                    </div>
                    <label for="userEmail" class="col-form-label col-md-2">Email</label>
                    <div class="col-md-4">
                        <input type="email" disabled name="email" id="userEmail" value="{{ auth()->user()->email }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="userRole" class="col-form-label col-md-2">{{ __('Role') }}</label>
                    <div class="col-md-4">
                        <input type="text" name="role" id="userRole" disabled value="{{ auth()->user()->role }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (auth()->user()->role === 'mahasiswa')
    @php
        $user = auth()->user()->student;
    @endphp
    <div class="card shadow mb-3">
        <form action="{{ route('mhs.profile.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="{{ $user->profile ? asset('storage/public/images/profil/mhs/' . $user->profile) : 'https://placehold.co/300x400' }}" class="img-fluid rounded-start" alt="Profile Picture">
                    <input class="form-control @error('profile') is-invalid @enderror" name="profile" type="file" id="formFile">
                    @error('profile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-9">
                    <div class="card-body">
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
                            <div class="col-md-10">
                                <textarea class="form-control @error('alamat_kantor') is-invalid @enderror" name="alamat_kantor" id="alamatKantor">{{ $user->alamat_kantor }}</textarea>
                                @error('alamat_kantor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h3 class="mb-2">Data Wali Mahasiswa</h3>
                        <div class="row mb-3 align-items-center">
                            <label for="namaWali" class="col-md-2">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <div class="form-floating">
                                    <input type="text" name="nama_wali" value="{{ $user->nama_wali }}" id="namaWali" placeholder="Nama Wali" required class="form-control @error('nama_wali') is-invalid @enderror">
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
                                    <textarea name="alamat_kantor_wali" id="alamatKantor" class="form-control" placeholder="Alamat Kantor">{{ $user->alamat_kantor_wali }}</textarea>
                                    <label for="alamatKantor">{{ __('Alamat Kantor') }}</label>
                                </div>
                                @error('alamat_kantor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    @endif


@endsection
