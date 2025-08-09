@push('styles')

<style>

    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
        }

        body {
        margin: 0;
        padding: 0;
        background: #f7f7f9;
        }

        .wizard-container {
        display: flex;
        max-width: auto;
        margin: 50px auto;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .wizard-sidebar {
        width: 250px;
        background: #fafafa;
        border-right: 1px solid #ddd;
        padding: 30px 20px;
        }

        .wizard-sidebar ol {
        list-style: none;
        padding: 0;
        margin: 0;
        }

        .wizard-sidebar li {
        display: flex;
        align-items: center;
        padding: 12px 10px;
        margin-bottom: 15px;
        background: #e9e9e9;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 500;
        }

        .wizard-sidebar li span {
        display: inline-block;
        width: 28px;
        height: 28px;
        margin-right: 12px;
        background: #c4c4c4;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 28px;
        font-weight: bold;
        transition: 0.3s;
        }

        .wizard-sidebar li.current,
        .wizard-sidebar li:hover {
        background: #38487c;
        color: white;
        }

        .wizard-sidebar li.current span,
        .wizard-sidebar li:hover span {
        background: white;
        color: #38487c;
        }

        .wizard-form {
        flex: 1;
        padding: 40px;
        animation: slideIn 0.3s ease-in-out;
        }

        .step {
        display: none;
        animation: fadeIn 0.5s ease;
        }

        .step.current {
        display: block;
        }

        .form-controls {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        }

        button {
        padding: 10px 25px;
        border: none;
        background: #38487c;
        color: white;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
        }

        button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        }

        button:hover:not(:disabled) {
        background: #a11854;
        }

        @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 768px) {
            .wizard-container {
                flex-direction: column;
            }

            .wizard-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }

            .wizard-form {
                padding: 20px;
            }

            .form-controls {
                flex-direction: column;
                gap: 10px;
            }

            .form-controls button {
                width: 100%;
            }
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
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="main-profile-cover text-fixed-white">
                            <div class="p-xl-5 p-2 z-1">
                                <div class="p-4 bg-black-transparent rounded-3 border border-opacity-10 border-white">
                                    <div class="d-flex gap-3 align-items-center flex-wrap">
                                        <div>
                                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="" class="img-fluid rounded-circle p-2 bg-success bg-opacity-25 shadow">
                                        </div>
                                        <div>
                                            <h4 class="text-fixed-white mb-1">{{ $profile->full_name ?? '' }}</h4>
                                            <p class="mb-1 op-6 fs-15">
                                                <i class="ri-briefcase-fill lh-1 align-middle me-2 d-inline-block"></i>
                                               @if($employee && $employee->designation_id)
                                                    {{ optional(\App\Models\Designation::find($employee->designation_id))->name ?? '' }}
                                                @else
                                                    <span>No designation available</span>
                                                @endif
                                            </p>
                                            <div class="d-flex gap-3 align-items-center flex-wrap">
                                                <p class="mb-0 op-6 fs-15">
                                                    <i class="ri-briefcase-line lh-1 align-middle me-2 d-inline-block"></i>
                                                    {{ $employee->number_staf ?? '' }}
                                                </p>
                                                <span class="op-3">|</span>
                                                <p class="mb-0 op-6 fs-15">
                                                    <i class="ri-mail-line lh-1 align-middle me-2 d-inline-block"></i>
                                                    {{ $profile->email ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
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
                        <div class="wizard-container">
                            <div class="wizard-sidebar">
                                <ol id="steps">
                                <li class="current" data-step="0"><span>1</span> Staff Information</li>
                                <li data-step="1"><span>2</span> Company Information</li>
                                <li data-step="2"><span>3</span> Branch</li>
                                <li data-step="3"><span>4</span> Department</li>
                                <li data-step="3"><span>5</span> Unit</li>
                                <li data-step="3"><span>6</span> Job Grade</li>
                                <li data-step="3"><span>7</span> Designation</li>
                                </ol>
                            </div>
                            <div class="wizard-form">
                                    <div class="step current">
                                        @include('pages.profile.my-profile.step.step-1-staff')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-2-company')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-3-branch')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-4-department')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-5-unit')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-6-job-grade')
                                    </div>
                                    <div class="step">
                                        @include('pages.profile.my-profile.step.step-7-designation')
                                    </div>
                                    <div class="form-controls">
                                        <button id="prevBtn" disabled>Previous</button>
                                        <button id="nextBtn">Next</button>
                                    </div>
                            </div>
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
            
            const getProfileUrl = "{{ route('project.update-profile.ajax', ['userId' => '__id__']) }}";

            const steps = document.querySelectorAll('.step');
            const sideSteps = document.querySelectorAll('.wizard-sidebar li');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');

            let currentStep = 0;

            function updateStep() {
                steps.forEach((step, index) => {
                    step.classList.toggle('current', index === currentStep);
                });

                sideSteps.forEach((li, index) => {
                    li.classList.toggle('current', index === currentStep);
                });

                prevBtn.disabled = currentStep === 0;

                nextBtn.textContent = (currentStep === steps.length - 1) ? 'Finish' : 'Next';
            }

            nextBtn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateStep();
                } else {

                    submitWizard();
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateStep();
                }
            });


            sideSteps.forEach((li, index) => {
                li.addEventListener('click', () => {
                    currentStep = index;
                    updateStep();
                });
            });

            updateStep();

            function submitWizard() {

                let userId = {{ auth()->id() }};
                let url = getProfileUrl.replace('__id__', userId);

                let formSelectors = {
                    staff: '#formStaff',
                    company: '#formCompany',
                    branch: '#formBranch',
                    department: '#formDepartment',
                    unit: '#formUnit',
                    job_grade: '#formJobGrade',
                    designation: '#formDesignation'
                };

                let formData = {};

                for (let key in formSelectors) {
                    formData[key] = {};
                    $(formSelectors[key]).serializeArray().forEach(field => {
                        formData[key][field.name] = field.value;
                    });
                }

                // Token & ID
                formData._token = '{{ csrf_token() }}';
                formData.id = userId;

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
                            $('#updateCompanyForm')[0].reset();
                            $('#updateCompanyModal').modal('hide');
                            $('#tablecompany').DataTable().ajax.reload(null, false);
                            // location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                let input = $('#updateCompanyForm').find(`[name="${field}"]`);
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
            }

        });

    </script>

@endpush
