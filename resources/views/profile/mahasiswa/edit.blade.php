@extends('layouts.template')

@section('content')
    <h1 class="mt-4">{{ __('My Profile') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">{{ __('My Profile') }}</li>
    </ol>
    <div class="card shadow mb-3">
        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="username" class="col-form-label col-md-2">Name</label>
                    <div class="col-md-4">
                        <input type="text"  name="name" id="username" value="{{ auth()->user()->name }}" class="form-control">
                    </div>
                    <label for="userEmail" class="col-form-label col-md-2">Email</label>
                    <div class="col-md-4">
                        <input type="email"  name="email" id="userEmail" value="{{ auth()->user()->email }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="userRole" class="col-form-label col-md-2">{{ __('Role') }}</label>
                    <div class="col-md-4">
                        <input type="text" name="role" id="userRole"  value="{{ auth()->user()->role }}" class="form-control">
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (auth()->user()->role === 'mahasiswa')

    <div class="card shadow mb-3">
        <div class="card-body">
            <form action="#">
                <div class="row mb-3">
                    <label for="mhsNim" class="col-form-label col-md-2">NIM</label>
                    <div class="col-md-4">
                        <input type="text" name="nim" id="mhsNim" class="form-control"  >
                    </div>
                </div>
            </form>
        </div>
    </div>

    @endif


@endsection
