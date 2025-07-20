<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Project</title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
        <link rel="icon" href="{{ asset('../assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
        <script src="{{ asset('.../assets/js/authentication-main.js') }}"></script>
        <link id="style" href="{{ asset('../assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
        <link href="{{ asset('../assets/css/styles.css') }}" rel="stylesheet" >
        <link href="{{ asset('../assets/css/icons.css') }}" rel="stylesheet" >
    </head>


<body>
    <div class="row authentication authentication-cover-main mx-0">
        <div class="col-xxl-6 col-xl-7">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-7 col-xl-9 col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card my-auto border authentication-cover-right">
                        <div class="card-body p-4">
                            <div class="text-center mb-4 bg-primary-transparent rounded border border-primary border-opacity-10 pt-2 position-relative overflow-hidden">
                                <i class="ri-lock-2-line position-absolute lock-icon-auth"></i>
                                <img src="../assets/images/authentication/6.png" alt="" class="img-fluid ms-4">
                            </div>
                            <div class="mt-3">
                                @error('error_message')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-xl-12 mt-2">
                                        <label class="form-label text-default" for="signup-email">Email Address<sup class="fs-12 text-danger">*</sup></label>
                                        <input class="form-control signup-email-input @error('email') is-invalid @enderror" id="signup-email" placeholder="Enter your email address" type="email" name="email" value="{{ old('email', session('email_value')) }}"> 
                                        <div>
                                            @error('email')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <label class="form-label text-default" for="signup-password">Password<sup class="fs-12 text-danger">*</sup></label>
                                        <div class="input-group"> 
                                            <input class="form-control signup-password-input @error('password') is-invalid @enderror" id="signup-password" placeholder="Create a password" type="password" name="password" value="{{ old('password', session('password_value')) }}"> 
                                            <button class="btn btn-primary-light show-password-button" type="button" onclick="createpassword('signup-password', this)">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </button>
                                        </div>
                                        <div>
                                            @error('password')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <label class="form-label text-default" for="create-confirmpassword">Confirm Password<sup class="fs-12 text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input class="form-control create-password-input @error('password_confirmation') is-invalid @enderror" id="create-confirmpassword" placeholder="Re-enter your password" type="password" name="password_confirmation" value="{{ old('password_confirmation', session('password_confirmation_value')) }}"> 
                                            <button class="btn btn-primary-light show-password-button" type="button" onclick="createpassword('create-confirmpassword',this)">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </button>
                                        </div>
                                        <div>
                                            @error('password_confirmation')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                    </div>
                                </div>
                                 <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-login-circle-line lh-1 me-2 align-middle"></i>Create Account
                                    </button>
                                </div>
                            </form>
                            <div class="text-center">
                                <p class="text-muted mt-3 mb-0">Already have an account? <a class="text-primary fw-medium text-decoration-underline" href="{{ route('login.form') }}">Sign In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-5 col-lg-12 d-xl-block d-none px-0">
            <div class="authentication-cover overflow-hidden">
                <div class="aunthentication-cover-content d-flex align-items-center justify-content-center">
                    <div>
                        <a href="index.html"> 
                            <img src="../assets/images/brand-logos/toggle-white.png" alt="" class="authentication-brand toggle-white img-fluid mb-4"> 
                        </a> 
                        <h4 class="text-fixed-white mb-2 fw-medium">Sign Up for <span class="text-secondary text-shadow">Your Account</span></h4>
                        <h6 class="text-fixed-white mb-3 fw-medium">Create Your Account Now</h6>
                        <p class="text-fixed-white mb-1 op-6">Fill in the details below to get started with your new account.</p>
                        <p class="text-fixed-white op-6 mb-5">Ensure you use a valid email address and create a strong password. Use a mix of letters, numbers, and symbols to protect your account from unauthorized access.</p>
                        <div class="d-flex mb-1 gap-2 flex-wrap flex-lg-nowrap">
                            <button class="btn btn-icon rounded-circle btn-sm d-flex align-items-center justify-content-center btn-info">
                                <i class="ri-twitter-x-line"></i>
                            </button>
                            <button class="btn btn-icon rounded-circle btn-sm d-flex align-items-center justify-content-center btn-pink">
                                <i class="ri-google-line fs-16"></i>
                            </button>
                            <button class="btn btn-icon rounded-circle btn-sm d-flex align-items-center justify-content-center btn-primary">
                                <i class="ri-facebook-line fs-16"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('../assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../assets/js/show-password.js') }}"></script>
</body>

</html>