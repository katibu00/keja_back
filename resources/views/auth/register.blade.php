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
    <title>Register | Subnow NG</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="/frontend/https://fonts.gstatic.com">
    <link href="/frontend/https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
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
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Back Button -->
    <div class="login-back-button"><a href="{{ route('login') }}">
        <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
        </svg></a></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <div class="custom-container">
        <div class="text-center px-4"><img class="login-intro-img mb-2" src="/logo.png" alt=""></div>
        <!-- Register Form -->
        <div class="register-form mt-4">
          <h6 class="mb-3 text-center">Register to continue to SubNow.</h6>
          <form id="register-form" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group text-start mb-3">
              <input class="form-control" type="text" name="name" placeholder="Enter your Name">
            </div>
            <div class="form-group text-start mb-3">
                <input class="form-control" type="text" name="phone" placeholder="Enter your Phone Number">
            </div>
            <div class="form-group text-start mb-3">
                <input class="form-control" type="email" name="email" placeholder="Enter your Email">
            </div>
        
            {{-- <div class="form-group text-start mb-3">
                <div class="d-flex align-items-center">
                    <select class="form-select me-2" id="bvnNinSelect" name="bvn_nin_select">
                        <option value="bvn">BVN</option>
                        <option value="nin">NIN</option>
                    </select>
                    <small><a href="#" data-bs-toggle="modal" data-bs-target="#bvnNinInfoModal">Why do we
                            need your BVN?</a></small>
                </div>
            </div> --}}

            {{-- <div class="form-group text-start mb-3" id="bvnField">
                <input class="form-control" type="text" name="bvn" placeholder="Enter your BVN">
            </div>
            <div class="form-group text-start mb-3" id="ninField" style="display: none;">
                <input class="form-control" type="text" name="nin" placeholder="Enter your NIN">
            </div> --}}

            <div class="form-group text-start mb-3 position-relative">
              <input class="form-control" id="psw-input" name="password" type="password" placeholder="New password">
              <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
            </div>
            <div class="mb-3" id="pswmeter"></div>
            {{-- <div class="form-check mb-3">
              <input class="form-check-input" id="checkedCheckbox" type="checkbox" value="" checked>
              <label class="form-check-label text-muted fw-normal" for="checkedCheckbox">I agree with the terms &amp; policy.</label>
            </div> --}}
            <button class="btn btn-primary w-100" type="submit">Sign Up</button>
          </form>
        </div>
        <!-- Login Meta -->
        <div class="login-meta-data text-center">
          <p class="mt-3 mb-0">Already have an account? <a class="stretcahed-link" href="{{ route('login') }}">Login</a></p>
        </div>
      </div>
    </div>

    <!-- BVN/NIN Info Modal -->
    <div class="modal fade" id="bvnNinInfoModal" tabindex="-1" aria-labelledby="bvnNinInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bvnNinInfoModalLabel">Why do we need your BVN?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your explanation here -->
                    <p>It is a requirement by the Central Bank of Nigeria (CBN) that all registered account holders must
                        link their BVN to their accounts for security and identification purposes.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bvnSelect = document.getElementById('bvnNinSelect');
            const bvnField = document.getElementById('bvnField');
            const ninField = document.getElementById('ninField');

            bvnSelect.addEventListener('change', function() {
                if (bvnSelect.value === 'bvn') {
                    bvnField.style.display = 'block';
                    ninField.style.display = 'none';
                } else {
                    bvnField.style.display = 'none';
                    ninField.style.display = 'block';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#register-form').submit(function(event) {
                event.preventDefault();
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
                );

                var formData = new FormData(this);
                var referralCode = getUrlParameter('referral_code');
                console.log(referralCode)
                if (referralCode) {
                    formData.append('referral_code', referralCode);
                }
                console.log("Form data:", formData);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/register',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        submitButton.prop('disabled', false).text('Login');

                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                window.location.href = '/login';
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        submitButton.prop('disabled', false).text('Login');

                        var response = xhr.responseJSON;
                        if (response && response.errors) {
                            var errorMessage = '';
                            $.each(response.errors, function(field, messages) {
                                errorMessage += messages[0] + '\n';
                            });
                            Swal.fire({
                                icon: 'warning',
                                title: 'Validation Error',
                                text: errorMessage
                            });
                        } else if (response && response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.'
                            });
                        }
                    }
                });
            });

            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }

        });
    </script>
  </body>
</html>