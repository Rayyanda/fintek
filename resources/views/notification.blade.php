@extends('layouts.template')

@section('content')
<h1 class="mt-4">Notifikasi</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>
<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        {{-- <th>No</th> --}}
                        <th>Pesan Notifikasi</th>
                        <th>Pengirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($notifications as $notif)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $notif->data['message'] }}</td>
                            <td>{{ $notif->data['pengirim'] }}</td>
                            <td>
                                @if ($notif->read_at)
                                    <span class="badge text-bg-success">Terbaca</span>
                                @else
                                <form action="{{ route('superadmin.notification.read') }}" method="post">
                                    @csrf
                                    <input type="text" name="id" value="{{ $notif->id }}"  hidden id="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
