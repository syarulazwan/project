@push('styles')

<style>
    #tableaccess thead th {
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Audit Management</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Access Log</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    {{-- <div class="card-header">
                        <div class="card-title">
                            Filter Datatable
                        </div>
                    </div> --}}
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    {{-- <div class="card-header">
                        <div class="card-title">
                            Basic Datatable
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableaccess" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Action Type</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                        <th>Login At</th>
                                        <th>Logout</th>
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

           $('#tableaccess').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: '{{ route("audit-management.access-log.ajax") }}',
                columns: [
                    { data: 'no' },
                    { data: 'user_id' },
                    { data: 'role_id' },
                    { data: 'action_type' },
                    { data: 'ip_address' },
                    { data: 'user_agent' },
                    { data: 'login_at' },
                    { data: 'logout_at' },
                    { data: 'action' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
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
                        width: '20%' 
                    }
                ]
            });

        });

    </script>
    
@endpush