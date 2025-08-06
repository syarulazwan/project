@push('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    #tableproject thead th {
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Project</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">List of Project</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addProjectModal">
                                    Add
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tableproject" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
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

    @include('pages.project.list-project.modal.add-modal')
    @include('pages.project.list-project.modal.update-modal')

@endsection

@push('scripts')

    <script>
        const getProjectUrl = "{{ route('project.update-project.ajax', ['userId' => '__id__']) }}";
        const deleteProjectUrl = "{{ route('project.delete-project.ajax', ['userId' => '__id__']) }}";
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>

        $(document).ready(function () {

            flatpickr("#start_date", {
                dateFormat: "Y-m-d"
            });

            flatpickr("#end_date", {
                dateFormat: "Y-m-d"
            });

            flatpickr("#start_date_update", {
                dateFormat: "Y-m-d"
            });

            flatpickr("#end_date_update", {
                dateFormat: "Y-m-d"
            });

           $('#tableproject').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: '{{ route("project.list-project.ajax") }}',
                columns: [
                    { data: 'no' },
                    { data: 'code' },
                    { data: 'name' },
                    { data: 'status' },
                    { data: 'start_date' },
                    { data: 'end_date' },
                    { data: 'action' }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        width: '5%' 
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
                        width: '20%' 
                    }
                ]
            });

        });

        $(document).ready(function () {

          $('#addProjectForm').on('submit', function(e) {
                e.preventDefault();

                $('#addProjectForm input, #addProjectForm select').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let name = $('#name').val();
                let code = $('#code').val();
                let status = $('#status').val();
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();

                $.ajax({
                    url: '{{ route("project.project.store") }}',
                    method: 'POST',
                    data: {
                        name: name,
                        code: code,
                        status: status,
                        start_date: start_date,
                        end_date: end_date,
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
                            $('#addProjectForm')[0].reset();
                            $('#addProjectModal').modal('hide');
                            $('#tableproject').DataTable().ajax.reload(null, false);
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

        $(document).on('click', '[data-bs-target="#updateProjectModal"]', function () {
            let button = $(this);


            $('#name_update').val(button.data('name'));
            $('#code_update').val(button.data('code'));
            $('#status_update').val(button.data('status'));
            $('#start_date_update').val(button.data('start_date'));
            $('#end_date_update').val(button.data('end_date'));
            $('#updateProjectForm').data('user-id', button.data('id'));

        });

         $(document).ready(function () {

            $('#updateProjectForm').on('submit', function(e) {
                e.preventDefault();

                let userId = $(this).data('user-id');

                let url = getProjectUrl.replace('__id__', userId);

                let formData = {
                    
                    _token: '{{ csrf_token() }}',
                    id: userId,
                    name_update: $('#name_update').val(),
                    code_update: $('#code_update').val(),
                    status_update: $('#status_update').val(),
                    start_date_update: $('#start_date_update').val(),
                    end_date_update: $('#end_date_update').val(),
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
                            $('#updateProjectForm')[0].reset();
                            $('#updateProjectModal').modal('hide');
                            $('#tableproject').DataTable().ajax.reload(null, false);
                            // location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                           let errors = xhr.responseJSON.errors;

                        for (let field in errors) {
                            let input = $('#updateProjectForm').find(`[name="${field}"]`);
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
                let url = deleteProjectUrl.replace('__id__', userId); 

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the Project!',
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
                                    $('#tableproject').DataTable().ajax.reload(null, false);
                                });
                            },
                            error: function (xhr) {
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
                        });
                    }
                });
            });

        });

    </script>
    
@endpush