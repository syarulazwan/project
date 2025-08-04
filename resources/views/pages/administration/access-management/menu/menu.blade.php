@push('styles')

<style>
    #tablemenu thead th {
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
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Menu</li>
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
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalScrollable3">
                                    Add
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tablemenu" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Route</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Priority</th>
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
    @include('pages.administration.access-management.menu.modal.add-modal')

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {


           $('#tablemenu').DataTable({
                //responsive: true,
                paging: false,
                searching: true, 
                ordering: true, 
                ajax: '{{ route("access-management.menu.ajax") }}',
                columns: [
                    { data: 'no'},
                    { data: 'name'},
                    { data: 'code'},
                    { data: 'route'},
                    { data: 'url'},
                    { data: 'icon'},
                    { data: 'priority'},
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

            $('#addMenuForm').on('submit', function(e) {
                e.preventDefault();

                $('#addMenuForm input, #addMenuForm select').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let name = $('#name').val();
                let code = $('#code').val();
                let url = $('#url').val();
                let route = $('#route').val();
                let icon = $('#icon').val();
                let priority = $('#priority').val();
                let parent_id = $('#parent_id').val();

                $.ajax({
                    url: '{{ route("access-management.menu.store") }}',
                    method: 'POST',
                    data: {
                        name: name,
                        code: code,
                        url: url,
                        route: route,
                        icon: icon,
                        priority: priority,
                        parent_id: parent_id
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
                            $('#addMenuForm')[0].reset();
                            $('#exampleModalScrollable3').modal('hide');
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            for (let field in errors) {
                                let input = $(`#${field}`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            }

                        } else {
                            let message = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
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