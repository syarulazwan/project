@push('styles')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #tablepermission thead th {
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Access Management</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Permission</li>
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
                                <label for="role" class="form-label">ROLE</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="">-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
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
                        <div class="table-responsive">
                            <table id="tablepermission" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Name Menu</th>
                                        <th>Is Menu</th>
                                        <th>Read ALL</th>
                                        <th>Read Single</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" id="updateAllBtn" class="btn btn-success">
                                <i class="fas fa-save"></i> Update All
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {

            $('#tablepermission').DataTable({

                // processing: true,
                // serverSide: true,

                paging: false,
                searching: true, 
                ordering: true, 
                ajax: {
                    url: '{{ route("access-management.permission.ajax") }}',
                    data: function(d) {
                        d.role_id = $('#role').val();
                    }
                },
                columns: [
                    { data: 'no' },
                    { data: 'name_menu'},
                    { data: 'is_menu'},
                    { data: 'read_all'},
                    { data: 'read_single'},
                    { data: 'add'},
                    { data: 'edit'},
                    { data: 'delete'},
                    { data: 'action'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
                    },
                    {
                        targets: 2,
                        className: 'text-center',
                    },
                    {
                        targets: 3,
                        className: 'text-center',
                    },
                    {
                        targets: 4,
                        className: 'text-center',
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
                    },
                    {
                        targets: 8,
                        className: 'text-center',
                        width: '20%' 
                    }
                ]
            });

            $('#searchBtn').on('click', function () {
                $('#tablepermission').DataTable().ajax.reload();
            });

            $('#clearBtn').on('click', function () {
                $('#role').val(null).trigger('change');
                $('#tablepermission').DataTable().ajax.reload();
            });

            $('#role').select2({
                placeholder: "-- Select Role --",
                width: '100%'
            });

        });

        $(document).ready(function () {

            $(document).on('click', '.update-permission', function () {

                let roleId = $(this).data('role_id');
                let menuId = $(this).data('menu_id');

                if (!roleId) {
                    Swal.fire('Warning', 'Please select a role first.', 'warning');
                    return;
                }

                let row = $(this).closest('tr');

                let formData = {
                    role_id: roleId,
                    menu_id: menuId,
                    is_menu: row.find('input[type=checkbox]').eq(0).is(':checked') ? 1 : 0,
                    read_all: row.find('input[type=checkbox]').eq(1).is(':checked') ? 1 : 0,
                    read_single: row.find('input[type=checkbox]').eq(2).is(':checked') ? 1 : 0,
                    add: row.find('input[type=checkbox]').eq(3).is(':checked') ? 1 : 0,
                    edit: row.find('input[type=checkbox]').eq(4).is(':checked') ? 1 : 0,
                    delete: row.find('input[type=checkbox]').eq(5).is(':checked') ? 1 : 0,
                };

                let url = '{{ route("access-management.updatePermission.ajax") }}';

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
       
                            $('#tablepermission').DataTable().ajax.reload(null, false);
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {

                                console.log(`Validation error on ${field}: ${errors[field][0]}`);
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

            $('#updateAllBtn').on('click', function () {

                let roleId = $('#role').val();
                if (!roleId) {
                    Swal.fire('Warning', 'Please select a role first.', 'warning');
                    return;
                }

                let permissions = [];
                $('#tablepermission tbody tr').each(function () {
                    let row = $(this);
                    let menuId = row.find('.update-permission').data('menu_id');

                    if (!menuId) return; // skip if no menu_id

                    permissions.push({
                        role_id: roleId,
                        menu_id: menuId,
                        is_menu: row.find('input[type=checkbox]').eq(0).is(':checked') ? 1 : 0,
                        read_all: row.find('input[type=checkbox]').eq(1).is(':checked') ? 1 : 0,
                        read_single: row.find('input[type=checkbox]').eq(2).is(':checked') ? 1 : 0,
                        add: row.find('input[type=checkbox]').eq(3).is(':checked') ? 1 : 0,
                        edit: row.find('input[type=checkbox]').eq(4).is(':checked') ? 1 : 0,
                        delete: row.find('input[type=checkbox]').eq(5).is(':checked') ? 1 : 0,
                    });
                });

                if (permissions.length === 0) {
                    Swal.fire('Info', 'No permissions to update.', 'info');
                    return;
                }

                let url = '{{ route("access-management.updatePermissionBulk.ajax") }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                   data: {
                            _token: '{{ csrf_token() }}',
                            permissions: permissions
                        },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
       
                            $('#tablepermission').DataTable().ajax.reload(null, false);
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {

                                console.log(`Validation error on ${field}: ${errors[field][0]}`);
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

    </script>
    
@endpush