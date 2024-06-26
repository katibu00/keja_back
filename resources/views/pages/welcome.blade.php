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
    <title>Welcome - Subnow NG</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    
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
   
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Hero Block Wrapper -->
    <div class="hero-block-wrapper bg-primary">
      <!-- Styles -->
      <div class="hero-block-styles">
        <div class="hb-styles1" style="background-image: url('img/core-img/dot.png')"></div>
        <div class="hb-styles2"></div>
        <div class="hb-styles3"></div>
      </div>
      <div class="custom-container">
        <!-- Skip Page -->
        <div class="skip-page"><a href="{{ route('login') }}">Login</a> | <a href="{{ route('register') }}">Register</a></div>
        <!-- Hero Block Content -->
        <div class="hero-block-content">
            <img class="mb-4" src="/logo.png" alt="">
            <h2 class="display-4 text-white mb-3">Welcome to Subnow NG,</h2>
            <p class="text-white">where convenience meets rewards! Experience the ultimate telecommunications experience in Nigeria with our seamless data and airtime recharge services. Plus, earn exciting bonuses every time you top up. Stay connected effortlessly and reap the rewards with our innovative offerings.</p>
            <a class="btn btn-warning btn-lg w-100 mb-2" href="{{ route('login') }}">Login</a>
            <a class="btn btn-success btn-lg w-100" href="{{ route('register') }}">Register</a>
        </div>
    </div>
    
      </div>
    </div>
    <!-- All JavaScript Files -->
    <script src="/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="/frontend/js/slideToggle.min.js"></script>
    <script src="/frontend/js/internet-status.js"></script>
    <script src="/frontend/js/tiny-slider.js"></script>
    <script src="/frontend/js/baguetteBox.min.js"></script>
    <script src="/frontend/js/countdown.js"></script>
    <script src="/frontend/js/rangeslider.min.js"></script>
    <script src="/frontend/js/vanilla-dataTables.min.js"></script>
    <script src="/frontend/js/index.js"></script>
    <script src="/frontend/js/magic-grid.min.js"></script>
    <script src="/frontend/js/dark-rtl.js"></script>
    <script src="/frontend/js/active.js"></script>
    <!-- PWA -->
    <script src="/frontend/js/pwa.js"></script>
  </body>
</html>