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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Existing Access</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">List of Document</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablerequest" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Role</th>
                                        <th>Created Name</th>
                                        <th>Created Time</th>
                                        <th>Updated Time</th>
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
                //responsive: true,
                paging: false,
                searching: true, 
                ordering: true, 
                ajax: '{{ route("existing-access.list-of-documents.ajax") }}',
                columns: [
                    { data: 'no'},
                    { data: 'role_name'},
                    { data: 'created_id'},
                    { data: 'created_at'},
                    { data: 'updated_at'}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
                    },
                    {
                        targets: 1,
                        className: 'text-center',
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
                        width: '20%' 
                    }
                ]
            });


        });

    </script>
    
@endpush