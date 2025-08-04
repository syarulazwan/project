@push('styles')

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
                        <!-- Dropdown on the left -->
                        <div class="col-md-6">
                            <label for="role" class="form-label">ROLE</label>
                            <select class="form-select" id="role" name="role">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons on the right -->
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
                $('#role').val('');
                $('#tablepermission').DataTable().ajax.reload();
            });

        });

    </script>
    
@endpush