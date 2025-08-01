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
        background: #410681;
        color: white;
        }

        .wizard-sidebar li.current span,
        .wizard-sidebar li:hover span {
        background: white;
        color: #410681;
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
        background: #410681;
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
                                <li class="current" data-step="0"><span>1</span> Personal Info</li>
                                <li data-step="1"><span>2</span> Address</li>
                                <li data-step="2"><span>3</span> Documents</li>
                                <li data-step="3"><span>4</span> Confirmation</li>
                                </ol>
                            </div>
                            <div class="wizard-form">
                                <div class="step current">
                                    <h4>Step 1: Personal Info</h4>
                                    <input type="text" class="form-control mb-3" placeholder="Your Name" />
                                    <input type="email" class="form-control" placeholder="Your Email" />
                                </div>
                                <div class="step">
                                    <h4>Step 2: Address</h4>
                                    <input type="text" class="form-control mb-3" placeholder="Street" />
                                    <input type="text" class="form-control" placeholder="City" />
                                </div>
                                <div class="step">
                                    <h4>Step 3: Documents</h4>
                                    <input type="file" class="form-control mb-3" />
                                </div>
                                <div class="step">
                                    <h4>Step 4: Confirmation</h4>
                                    <p>Thank you! Please confirm your information and submit.</p>
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
        nextBtn.textContent = currentStep === steps.length - 1 ? 'Finish' : 'Next';
        }

        nextBtn.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            updateStep();
        } else {
            alert("Form completed!");
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


    </script>
    
@endpush