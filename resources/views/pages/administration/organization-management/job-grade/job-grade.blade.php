@push('styles')

<style>
    #tablejobgrade thead th {
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
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Organization Management</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Job Grade</li>
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
                                    data-bs-target="#addJobGradeModal">
                                    Add
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tablejobgrade" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Level</th>
                                        <th>Seniority</th>
                                        <th>Created ID</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
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

    @include('pages.administration.organization-management.job-grade.modal.add-modal')
    @include('pages.administration.organization-management.job-grade.modal.update-modal')

@endsection

@push('scripts')

    <script>
        const getJobGradeUrl = "{{ route('organization-management.update-job-grade.ajax', ['userId' => '__id__']) }}";
        const deleteJobGradeUrl = "{{ route('organization-management.delete-job-grade.ajax', ['userId' => '__id__']) }}";
    </script>
    <script>

        $(document).ready(function () {

           $('#tablejobgrade').DataTable({
                // responsive: true,
                lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                ajax: '{{ route("organization-management.job-grade.ajax") }}',
                columns: [
                    { data: 'no' },
                    { data: 'name' },
                    { data: 'code' },
                    { data: 'level' },
                    { data: 'seniority' },
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

        });

        $(document).ready(function () {

          $('#addJobGradeForm').on('submit', function(e) {
                e.preventDefault();

                $('#addJobGradeForm input, #addJobGradeForm select').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                let name = $('#name').val();
                let code = $('#code').val();
                let level = $('#level').val();
                let seniority = $('#seniority').val();

                $.ajax({
                    url: '{{ route("organization-management.job-grade.store") }}',
                    method: 'POST',
                    data: {
                        name: name,
                        code: code,
                        level: level,
                        seniority: seniority,
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
                            $('#addJobGradeForm')[0].reset();
                            $('#addJobGradeModal').modal('hide');
                            $('#tablejobgrade').DataTable().ajax.reload(null, false);
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

        $(document).on('click', '[data-bs-target="#updateJobGradeModal"]', function () {
            let button = $(this);


            $('#name_update').val(button.data('name'));
            $('#code_update').val(button.data('code'));
            $('#level_update').val(button.data('level'));
            $('#seniority_update').val(button.data('seniority'));
            $('#updateJobGradeForm').data('user-id', button.data('id'));

        });

         $(document).ready(function () {

            $('#updateJobGradeForm').on('submit', function(e) {
                e.preventDefault();

                let userId = $(this).data('user-id');

                let url = getJobGradeUrl.replace('__id__', userId);

                let formData = {
                    
                    _token: '{{ csrf_token() }}',
                    id: userId,
                    name_update: $('#name_update').val(),
                    code_update: $('#code_update').val(),
                    level_update: $('#level_update').val(),
                    seniority_update: $('#seniority_update').val(),
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
                            $('#updateJobGradeForm')[0].reset();
                            $('#updateJobGradeModal').modal('hide');
                            $('#tablejobgrade').DataTable().ajax.reload(null, false);
                            // location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                           let errors = xhr.responseJSON.errors;

                        for (let field in errors) {
                            let input = $('#updateJobGradeForm').find(`[name="${field}"]`);
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
                let url = deleteJobGradeUrl.replace('__id__', userId); 

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the Job Grade!',
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
                                    $('#tablejobgrade').DataTable().ajax.reload(null, false);
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