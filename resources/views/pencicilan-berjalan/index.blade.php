@extends('layouts.template')

@section('content')
<h1 class="mt-4">Pencicilan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Berjalan</li>
    </ol>
    <p>Tahun Ajaran : {{ $tahunAjaran->tahun_ajaran }}</p>
    <p>Semester : {{ $tahunAjaran->semester }}</p>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('swal'))
    {{ session('swal') }}
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ $error }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
    @endif
    <div class="card mb-3 shadow">
        <div class="card-header d-flex justify-content-end">

        </div>
        <div class="card-body">
            <form id="formSendMail">
                @csrf
                <button type="submit" class="btn btn-primary" >Kirim Broadcast Pembayaran</button>
                <div id="responseMessage" class="mt-3"></div>
                <div class="table-responsive p-2">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jumlah Cicilan</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Pengajuan Perubahan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pencicilans as $cicilan)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="user[{{ $cicilan->penundaan->student->user_id }}][{{ $cicilan->id }}]" id="cid-{{ $cicilan->id }}" class="form-check">
                                </td>
                                <td>{{ $cicilan->penundaan->student->nim }}</td>
                                <td>{{ $cicilan->penundaan->student->user->name }}</td>
                                <td>Rp. {{ number_format($cicilan->cicilan) }}</td>
                                <td>{{ $cicilan->tgl_jatuh_tempo }}</td>
                                <td>
                                    @switch($cicilan->status)
                                        @case("Lunas")
                                            <span class="badge text-bg-success">{{ $cicilan->status }}</span>
                                            @break
                                        @default
                                            <span class="badge text-bg-danger">{{ $cicilan->status }}</span>

                                    @endswitch
                                </td>
                                <td>
                                    @if ($cicilan->perubahan)
                                    <form action="{{ route('superadmin.penundaan.show',$cicilan->penundaan->student->student_id) }}" method="get">
                                        <input type="text" name="tahun_ajaran" id="tahunAjaran" value="{{ $cicilan->penundaan->tahun_ajaran }}" hidden>
                                        <input type="text" name="semester" id="semester" value="{{ $cicilan->penundaan->semester }}" hidden>
                                        <button type="submit" class="btn btn-warning btn-sm" title="Lihat Detail"><i class="fa fa-eye"></i></button>
                                    </form>
                                    @else
                                    <span class="badge text-bg-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td></td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <small class="text-secondary"><i class="fa fa-info-circle"></i> Secara default, data berdasarkan yang jatuh tempo bulan ini.</small>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#formSendMail').on('submit', function(e) {
                e.preventDefault();

                $('#responseMessage').html('<div class="alert alert-info">Memproses <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>');
                //console.log('sedang mengirim');

                $.ajax({
                    url: '{{ route('superadmin.send-warning') }}', // Sesuaikan dengan route Anda
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.status === 'success') {
                            window.location.reload();
                        } else {
                            $('#responseMessage').html(
                                `<div class="alert alert-danger">
                                    ${response.message || 'Terjadi kesalahan'}
                                </div>`
                            );
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan pada server';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        $('#responseMessage').html(
                            `<div class="alert alert-danger alert-dissmissible">${errorMsg}</div>`
                        );
                    }
                });
            });
        });
    </script>
@endsection
