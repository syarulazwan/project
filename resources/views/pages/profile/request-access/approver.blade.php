@push('styles')

<style>
    #tablerequest thead th {
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Profile</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Request Access</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Approver</li>
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
                            <table id="tablerequest" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Name</th>
                                        <th>Request Type</th>
                                        <th>Request Role Name</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th>Approved Time</th>
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


           $('#tablerequest').DataTable({

                paging: false,
                searching: true, 
                ordering: true, 
                ajax: '{{ route("profile.request-access-to-document.approver.ajax") }}',
                columns: [
                    { data: 'no'},
                    { data: 'user_name'},
                    { data: 'request_type'},
                    { data: 'requested_role_name'},
                    { data: 'status'},
                    { data: 'approved_by'},
                    { data: 'approved_at'},
                    { data: 'action'},
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


        });

    </script>
    
@endpush