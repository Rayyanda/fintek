@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light shadow" style="--bs-bg-opacity: .5;">
                <div class="card-body">
                    <h3 class="mb-2">{{ __('Register') }}</h3>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <button class="nav-link active" id="nav-mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#nav-mahasiswa" type="button" role="tab" aria-controls="nav-mahasiswa" aria-selected="true">Mahasiswa</button>
                          <button class="nav-link" id="nav-dosen-tab" data-bs-toggle="tab" data-bs-target="#nav-dosen" type="button" role="tab" aria-controls="nav-dosen" aria-selected="false">dosen</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active pt-3" id="nav-mahasiswa" role="tabpanel" aria-labelledby="nav-mahasiswa-tab" tabindex="0">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-2 col-form-label">{{ __('Name') }}</label>

                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus name="name" value="{{ old('name') }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="mhsNim" class="col-md-2 col-form-label">NIM</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nim" id="mhsNim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required>
                                        @error('nim')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <label for="email" class="col-md-2 col-form-label">{{ __('Email Address') }}</label>

                                    <div class="col-md-4">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
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
                                        <select class="form-select" name="prodi">
                                            <option selected>Open this select menu</option>
                                            <option value="Sistem Informasi">Sistem Informasi</option>
                                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                                            <option value="Teknik Mesin">Teknik Mesin</option>
                                            <option value="Teknik Industri">Teknik Industri</option>
                                            <option value="Teknik Elektro">Teknik Elektro</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="semester" class="col-form-label col-md-2">Semester</label>
                                    <div class="col-md-4">
                                        <input type="number" name="semester" value="{{ old('semester') }}" id="semester" required class="form-control @error('semester') is--invalid @enderror">
                                        @error('semester')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <label for="gpa" class="col-form-label col-md-2">IPK</label>
                                    <div class="col-md-4">
                                        <input type="text"  name="ipk" value="{{ old('ipk') }}" id="gpa" required class="form-control @error('ipk') is-invalid @enderror">
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
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="jenisKelas" class="col-form-label col-md-2">{{ __('Class Type') }}</label>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" name="jenis_kelas" id="jenisKelas">
                                                <option selected>Open this select menu</option>
                                                <option value="Pagi">Reguler Pagi</option>
                                                <option value="Malam">Reguler Malam</option>
                                            </select>
                                            <label for="jenisKelas">{{ __('Class Type') }}</label>
                                        </div>
                                    </div>
                                    <label for="noTelp" class="col-form-label col-md-2">{{ __('Phone Number') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" name="no_telp" id="noTelp" value="{{ old('no_telp') }}"  required class="form-control @error('no_telp') is-invalid @enderror">
                                        @error('no_telp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-2 col-form-label">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-2 col-form-label">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-dosen" role="tabpanel" aria-labelledby="nav-dosen-tab" tabindex="0">...</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
