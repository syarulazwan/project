@push('styles')

<style>
    #tableuser thead th {
    text-align: center !important;
    vertical-align: middle !important;
    text-transform: uppercase;
}

</style>

   
@endpush

@extends('main')
@section('pages')

    <div class="container-fluid">
        <div class="d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="">
                <nav>
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '/'; color: rgb(0, 0, 0);">
                        <li class="breadcrumb-item d-flex align-items-center">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="bi bi-house-door-fill me-1"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Administration</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">User Management</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row mb-3 align-items-end">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status">
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="button" class="btn btn-primary" id="searchBtn" title="Search">
                                        <i class="fas fa-search"></i> 
                                    </button>
                                    <button type="button" class="btn btn-danger" id="clearBtn" title="Clear">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addUserModal">
                                    Add
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tableuser" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created ID</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.administration.user-management.user.modal.add-modal')
    @include('pages.administration.user-management.user.modal.add-user-modal')
    @include('pages.administration.user-management.user.modal.update-user-modal')

@endsection

@push('scripts')
    <script>
        const getUserRolesUrl = "{{ route('user-management.getUserRoles.ajax', ['userId' => '__id__']) }}";
        const getUserUrl = "{{ route('user-management.updateUser.ajax', ['userId' => '__id__']) }}";
        const deleteUserUrl = "{{ route('user-management.deleteUser.ajax', ['userId' => '__id__']) }}";
    </script>
    <script>

        $(document).ready(function () {

           $('#tableuser').DataTable({
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: {
                    url: '{{ route("user-management.user.ajax") }}',
                    data: function(d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'status' },
                    { data: 'created_id' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                    { data: 'action' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
                    },
                     {
                        targets: 5,
                        className: 'text-center',
                    },
                    {
                        targets: 6,
                        className: 'text-center',
                    },
                    {
                        targets: 7,
                        className: 'text-center',
                        width: '20%' 
                    }
                ]
            });

            $('#searchBtn').on('click', function () {
                $('#tableuser').DataTable().ajax.reload();
            });

            $('#clearBtn').on('click', function () {
                $('#name').val('');
                $('#email').val('');
                $('#status').val('');
                $('#tableuser').DataTable().ajax.reload();
            });

        });

        $(document).ready(function () {
            let selectedRoles = [];

            $('#exampleModalScrollable3').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget);
                let userId = button.data('id');
                let url = getUserRolesUrl.replace('__id__', userId);

                $('#user_id').val(userId);
                selectedRoles = [];

                $('#roleTable tbody').html('');
                $('#role').html('<option value="">-- Select Role --</option>');

                $.ajax({
                    url: '{{ route("user-management.getRole.ajax") }}',
                    method: 'GET',
                    success: function (roles) {
                        roles.forEach(function (role) {
                            $('#role').append(`<option value="${role.id}">${role.name}</option>`);
                        });

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function (userRoles) {
                                userRoles.forEach(function (role) {
                                    selectedRoles.push(String(role.id));
                                    $('#roleTable tbody').append(`
                                        <tr data-role-id="${role.id}">
                                            <td>${role.name}</td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-role">Delete</button></td>
                                        </tr>
                                    `);
                                    $('#role option[value="' + role.id + '"]').hide();
                                });
                            },
                            error: function () {
                                alert('Gagal ambil role user.');
                            }
                        });
                    },
                    error: function () {
                        alert('Gagal ambil senarai role.');
                    }
                });
            });

            $('#addRoleBtn').on('click', function () {
                let selectedOption = $('#role option:selected');
                let roleId = selectedOption.val();
                let roleName = selectedOption.text();

                if (!roleId) {
                    alert('Sila pilih role.');
                    return;
                }

                if (selectedRoles.includes(roleId)) {
                    alert('Role telah ditambah.');
                    return;
                }

                selectedRoles.push(roleId);
                $('#roleTable tbody').append(`
                    <tr data-role-id="${roleId}">
                        <td>${roleName}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-role">Delete</button></td>
                    </tr>
                `);

                selectedOption.hide();
                $('#role').val('');
            });

            $(document).on('click', '.remove-role', function () {
                let row = $(this).closest('tr');
                let roleId = row.data('role-id').toString();

                selectedRoles = selectedRoles.filter(id => id !== roleId);
                $('#role option[value="' + roleId + '"]').show();
                row.remove();
            });

            $('#saveBtn').on('click', function (e) {
                e.preventDefault();
                let userId = $('#user_id').val();

               $.ajax({
                    url: '{{ route("user-management.assignRoles.ajax") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        roles: selectedRoles
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berjaya!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#exampleModalScrollable3').modal('hide');
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal simpan roles.',
                            confirmButtonText: 'Cuba Lagi'
                        });
                    }
                });

            });
        });

        $(document).ready(function () {
         $('#addUserForm').on('submit', function(e) {
                e.preventDefault();

                $('#addUserForm input, #addUserForm select').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let name_add = $('#name_add').val();
                let email_add = $('#email_add').val();
                let password_add = $('#password_add').val();
                let status_add = $('#status_add').val();

                $.ajax({
                    url: '{{ route("user-management.store.ajax") }}',
                    method: 'POST',
                    data: {
                        name_add: name_add,
                        email_add: email_add,
                        password_add: password_add,
                        status_add: status_add,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#addUserForm')[0].reset();
                            $('#addUserModal').modal('hide');
                            $('#tableuser').DataTable().ajax.reload(null, false);
                            // location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                           let errors = xhr.responseJSON.errors;

                        for (let field in errors) {
                            let input = $('#addUserForm').find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                        }

                        } else {
                            let message = 'Something went wrong!';

                            if (xhr.responseJSON) {

                                if (xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                if (xhr.responseJSON.error) {
                                    message += `\n\nError: ${xhr.responseJSON.error}`;
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: message,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Close'
                            });
                        }

                    }
                });
            });
        });

        $(document).on('click', '[data-bs-target="#updateUserModal"]', function () {
            let button = $(this);

            $('#name_update').val(button.data('name'));
            $('#email_update').val(button.data('email'));
            $('#status_update').val(button.data('status')).trigger('change');
            $('#updateUserForm').data('user-id', button.data('id'));
        });


        $(document).ready(function () {

            $('#updateUserForm').on('submit', function(e) {
                e.preventDefault();

                let userId = $(this).data('user-id');

                let url = getUserUrl.replace('__id__', userId);

                let formData = {
                    
                    _token: '{{ csrf_token() }}',
                    id: userId,
                    name_update: $('#name_update').val(),
                    email_update: $('#email_update').val(),
                    status_update: $('#status_update').val()
                };

                 $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#updateUserForm')[0].reset();
                            $('#updateUserForm').modal('hide');
                            $('#tableuser').DataTable().ajax.reload(null, false);
                            // location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                           let errors = xhr.responseJSON.errors;

                        for (let field in errors) {
                            let input = $('#updateUserForm').find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                        }

                        } else {
                            let message = 'Something went wrong!';

                            if (xhr.responseJSON) {

                                if (xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                if (xhr.responseJSON.error) {
                                    message += `\n\nError: ${xhr.responseJSON.error}`;
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: message,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Close'
                            });
                        }

                    }
                });
            });

        });

        $(document).ready(function () {

            $(document).on('click', '.btn-delete', function () {
                let userId = $(this).data('id');
                let url = deleteUserUrl.replace('__id__', userId); 

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berjaya!',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    $('#tableuser').DataTable().ajax.reload(null, false);
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ralat!',
                                    text: 'Tidak berjaya memadam pengguna.',
                                    confirmButtonColor: '#d33'
                                });
                            }
                        });
                    }
                });
            });

        });






    </script>
    
@endpush