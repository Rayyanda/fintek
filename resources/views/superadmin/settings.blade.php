@extends('layouts.template')

@section('content')
<h1 class="mt-4">Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Setting</li>
</ol>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-3">
            <!-- Nav Vertikal -->
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-account-setting-tab" data-bs-toggle="pill" data-bs-target="#v-account-setting" type="button" role="tab" aria-controls="v-account-setting" aria-selected="true">Pengaturan Akun</button>
                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profil</button>
                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Pesan</button>
                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Pengaturan</button>
            </div>
        </div>
        <div class="col-9">
            <!-- Konten Tab -->
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-account-setting" role="tabpanel" aria-labelledby="v-account-setting-tab" tabindex="0">

                    <div class="card mb-3 shadow">
                        <div class="card-header">
                            <h3>Pengaturan Akun</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2 align-items-center">
                                <label for="name" class="col-form-label col-md-2">Name</label>
                                <div class="col-md 10">
                                    <div class="form-floating">
                                        <input type="text" name="name" value="{{ auth()->user()->name }}" id="name" class="form-control">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <label for="email" class="col-form-label col-md-2">Email</label>
                                <div class="col-md-10">
                                    <div class="form-floating">
                                        <input type="email" name="email" value="{{ auth()->user()->email }}" id="email" class="form-control">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <label for="password" class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="password" name="password" id="password" class="form-control">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <label for="confirmPassword" class="col-md-2 col-form-label">Confirm Password</label>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control">
                                        <label for="confirmPassword">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    <h3>Halaman Profil</h3>
                    <p>Ini adalah konten untuk halaman profil. Tampilkan informasi profil pengguna di sini.</p>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
                    <h3>Halaman Pesan</h3>
                    <p>Ini adalah konten untuk halaman pesan. Tampilkan daftar pesan atau kotak masuk di sini.</p>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <h3>Halaman Pengaturan</h3>
                    <p>Ini adalah konten untuk halaman pengaturan. Berikan opsi pengaturan aplikasi di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
