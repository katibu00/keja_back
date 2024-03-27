<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <title>@yield('pageTitle') | SubNow</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="/frontend/https://fonts.gstatic.com">
    <link href="/frontend/https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="/frontend/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="/frontend/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/frontend/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/frontend/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/frontend/img/icons/icon-180x180.png">
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
    @yield('css')
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- # Paste your Header Content from here -->
        <!-- # Header Five Layout -->
        <!-- # Copy the code from here ... -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
          <!-- Logo Wrapper -->
          <div class="logo-wrapper"><a href="page-home.html"><img src="/frontend/img/core-img/logo.png" alt=""></a></div>
          <!-- Navbar Toggler -->
          <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
        </div>
        <!-- # Header Five Layout End -->
      </div>
    </div>
    <!-- # Sidenav Left -->
    <!-- Offcanvas -->
    @include('layout.sidebar.index')
    
    @yield('content')
    <!-- Footer Nav -->
    @include('layout.footer')
    <!-- All JavaScript Files -->
    <script src="/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="/frontend/js/slideToggle.min.js"></script>
    <script src="/frontend/js/internet-status.js"></script>
    <script src="/frontend/js/tiny-slider.js"></script>
    <script src="/frontend/js/baguetteBox.min.js"></script>
    {{-- <script src="/frontend/js/countdown.js"></script> --}}
    <script src="/frontend/js/rangeslider.min.js"></script>
    <script src="/frontend/js/vanilla-dataTables.min.js"></script>
    <script src="/frontend/js/index.js"></script>
    <script src="/frontend/js/magic-grid.min.js"></script>
    <script src="/frontend/js/dark-rtl.js"></script>
    <script src="/frontend/js/active.js"></script>
    <!-- PWA -->
    <script src="/frontend/js/pwa.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('js')
  </body>
</html>