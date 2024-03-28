<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="description" content="SubNow.ng - Nigeria's #1 data and airtime portal, offering innovative solutions for purchasing data and airtime with ease. Revolutionize your digital connectivity experience with SubNow.ng.">
    <meta name="keywords" content="SubNow, SubNow.ng, Nigeria, data portal, airtime portal, buy data, buy airtime, digital connectivity, internet access, innovative, convenience">
    <meta name="author" content="Subnow NG">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="SubNow.ng - Nigeria's Premier Data and Airtime Portal">
    <meta property="og:description" content="Welcome to SubNow.ng, Nigeria's premier data and airtime portal, revolutionizing how internet users access data and airtime effortlessly.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://subnow.ng/">
    <meta property="og:image" content="https://subnow.ng/uploads/logo.png">
    <meta property="og:site_name" content="SubNow.ng">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SubNow.ng - Nigeria's Premier Data and Airtime Portal">
    <meta name="twitter:description" content="Welcome to SubNow.ng, Nigeria's premier data and airtime portal, revolutionizing how internet users access data and airtime effortlessly.">
    <meta name="twitter:image" content="https://subnow.ng/uploads/logo.png">


    <!-- Title -->
    <title>Login | Subnow NG</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="/frontend/https://fonts.gstatic.com">
    <link
        href="/frontend/https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    {{-- <link rel="icon" href="/frontend/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="/frontend/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/frontend/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/frontend/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/frontend/img/icons/icon-180x180.png"> --}}
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/frontend/css/tiny-slider.css">
    <link rel="stylesheet" href="/frontend/css/baguetteBox.min.css">
    <link rel="stylesheet" href="/frontend/css/rangeslider.css">
    <link rel="stylesheet" href="/frontend/css/vanilla-dataTables.min.css">
    <link rel="stylesheet" href="/frontend/css/apexcharts.css">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/frontend/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="/frontend/manifest.json">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Back Button -->
    <div class="login-back-button"><a href="#">
            <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z">
                </path>
            </svg></a></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4"><img class="login-intro-img mb-4"  src="/logo.png" alt="">
            </div>
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Register Form -->
            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Log in to continue to SubNow.</h6>
                <form id="login-form" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="text" name="email_or_phone" placeholder="Email/Phone number">
                    </div>
                    <div class="form-group position-relative">
                        <input class="form-control" id="psw-input" name="password" type="password" placeholder="Enter Password">
                        <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" checked>
                        <label class="form-check-label" for="remember_me">
                            Keep me logged in
                        </label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                </form>
            </div>
            
            <!-- Login Meta -->
            <div class="login-meta-data d-flex justify-content-between mt-3 mb-1">
                <a class="stretched-link" href="{{ route('register') }}">Register an Account</a>
                <a class="stretched-link forgot-password d-block " href="{{ route('password.forgot') }}">Forgot Password?</a>
            </div>
            
        </div>
    </div>
    <!-- All JavaScript Files -->
    <script src="/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="/frontend/js/internet-status.js"></script>
    <script src="/frontend/js/dark-rtl.js"></script>
    <!-- Password Strenght -->
    <script src="/frontend/js/pswmeter.js"></script>
    <script src="/frontend/js/active.js"></script>
    <!-- PWA -->
    <script src="/frontend/js/pwa.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(event) {
                event.preventDefault();
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
                );

                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('login') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        submitButton.prop('disabled', false).text('Login');

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful',
                                text: 'Redirecting to dashboard...',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        window.location.href = response
                                            .redirect_url;
                                    }, 500);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Credentials',
                                text: 'Login Credentials do not matched.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        submitButton.prop('disabled', false).text('Login');

                        var response = xhr.responseJSON;
                        if (response && response.errors && response.errors.login_error) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Login Error',
                                text: response.errors.login_error[0]
                            });
                        } else if (response && response.message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'An Error Occurred',
                                text: 'Please try again later.'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
