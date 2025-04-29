@extends('layouts.template')

@section('content')
<h1 class="mt-4" >Pengguna</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Pengguna</li>
</ol>

<div class="card mb-3 shadow">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-didver">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formNewUser" >
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">User Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2 align-items-center">
                        <label for="userName" class="col-form-label col-md-2">Name</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" name="name" placeholder="Name" required id="userName" class="form-control">
                                <label for="userName">Name</label>
                            </div>
                        </div>
                        <label for="userEmail" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="email" name="email" required id="userEmail" placeholder="example@gmail.com" class="form-control">
                                <label for="userEmail">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                        <label for="userPassword" class="col-form-label col-md-2">Password</label>
                        <div class="col-md-4">
                            <div class="form-floating">

                            </div>
                        </div>
                    </div>
                    <div id="responseMessage" class="mt-3"></div>
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
    $(document).ready(function() {
    $('#formNewUser').on('submit', function(e) {
        e.preventDefault();

        // Tampilkan loading indicator
        $('#responseMessage').html('<div class="alert alert-info">Memproses...</div>');

        $.ajax({
            url: '/send-emails', // Sesuaikan dengan route Anda
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
                    `<div class="alert alert-danger">${errorMsg}</div>`
                );
            }
        });
    });
});
</script>

@endsection
