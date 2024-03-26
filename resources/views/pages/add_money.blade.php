<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Finwallapp - Mobile HTML template</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="img/favicon180.png" sizes="180x180">
    <link rel="icon" href="img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Material icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- swiper CSS -->
    <link href="/theme/vendor/swiper/css/swiper.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/theme/css/style.css" rel="stylesheet" id="style">
</head>

<body class="body-scroll d-flex flex-column h-100 menu-overlay" data-page="addmoney">
    <!-- screen loader -->
    <div class="container-fluid h-100 loader-display">
        <div class="row h-100">
            <div class="align-self-center col">
                <div class="logo-loading">
                    <div class="icon icon-100 mb-4 rounded-circle">
                        <img src="/theme/img/favicon144.png" alt="" class="w-100">
                    </div>
                    <h4 class="text-default">Finwallapp</h4>
                    <p class="text-secondary">Mobile HTML template</p>
                    <div class="loader-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Begin page content -->
    <main class="flex-shrink-0 main">
        <!-- Fixed navbar -->
        <header class="header">
            <div class="row">
                <div class="col-auto px-0">
                    <button class="menu-btn btn btn-40 btn-link back-btn" type="button">
                        <span class="material-icons">keyboard_arrow_left</span>
                    </button>
                </div>
                <div class="text-left col align-self-center">
                    <a class="navbar-brand" href="#">
                        <h5 class="mb-0">Add Money</h5>
                    </a>
                </div>
                <div class="ml-auto col-auto">
                    <a href="profile.html" class="avatar avatar-30 shadow-sm rounded-circle ml-2">
                        <figure class="m-0 background">
                            <img src="/default.png" alt="">
                        </figure>
                    </a>
                </div>
            </div>
        </header>

        <div class="main-container">
            <div class="container mb-4">
                <p class="text-center text-secondary mb-1">Enter Amount to Add</p>
                <div class="form-group mb-1">
                    <input type="text" class="form-control large-gift-card" value="100.00" placeholder="00.00">
                </div>
                <p class="text-center text-secondary mb-4">Available: $ 1,050.00 </p>
               
                <div class="alert alert-success">
                    <div class="media">
                        <div class="icon icon-40 bg-white text-success mr-2 rounded-circle"><i class="material-icons">wb_incandescent</i></div>
                        <div class="media-inner">
                            <h6 class="mb-0 font-weight-normal">
                                <b>How To Fund your Wallet</b><br>
                                <small class="text-mute">To fund your wallet, select an account number<br> below, open your bank app, and transfer the<br> desired amount. Your wallet balance will<br> update in seconds upon successful transfer.</small>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mb-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                {{-- <div class="custom-control custom-switch">
                                    <input type="radio" name="paynow" class="custom-control-input" id="pay2" checked="">
                                    <label class="custom-control-label" for="pay2"></label>
                                </div> --}}
                            </div>
                            <div class="col pl-0">
                                <h6 class="subtitle mb-0"> Automated Bank Transfer</h6>
                            </div>
                            {{-- <div class="col-auto pl-0">
                                <p class="text-secondary text-center"><a href="addcard.html">Add </a></p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="swiper-container swipercards">
                            <div class="swiper-wrapper pb-4">
                             

                                @if (is_array($accounts) && count($accounts) > 0)
                                @php
                                    $bgColors = ['bg-default', 'bg-warning', 'bg-danger', 'bg-success'];
                                    $colorIndex = 0;
                                @endphp
                            
                                @foreach ($accounts as $key => $account)
                                    @php
                                        $bgColorClass = $bgColors[$colorIndex % count($bgColors)];
                                        $colorIndex++;
                                    @endphp
                            
                                    <div class="swiper-slide">
                                        <div class="card border-0 {{ $bgColorClass }} text-white">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <i class="material-icons vm text-template">credit_card</i>
                                                    </div>
                                                    <div class="col pl-0">
                                                        <h6 class="mb-1">{{ $account['bankName'] }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="mb-0 mt-3">{{ $account['accountNumber'] }} <i class="material-icons copy-icon" data-account="{{ $account['accountNumber'] }}">content_copy</i></h5>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="mb-0">N50</p>
                                                        <p class="small">Charges</p>
                                                    </div>
                                                    <div class="col-auto align-self-center text-right">
                                                        <p class="mb-0">{{ $account['accountName'] }}</p>
                                                        <p class="small">Account Name</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </main>


    <!-- Required jquery and libraries -->
    <script src="/theme/js/jquery-3.3.1.min.js"></script>
    <script src="/theme/js/popper.min.js"></script>
    <script src="/theme/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- cookie js -->
    <script src="/theme/js/jquery.cookie.js"></script>

    <!-- Swiper slider  js-->
    <script src="/theme/vendor/swiper/js/swiper.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="/theme/js/main.js"></script>
    <script src="/theme/js/color-scheme-demo.js"></script>


    <!-- page level custom script -->
    <script src="/theme/js/app.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const copyIcons = document.querySelectorAll(".copy-icon");
    
            copyIcons.forEach(icon => {
                icon.addEventListener("click", function () {
                    const accountNumber = this.getAttribute("data-account");
                    copyToClipboard(accountNumber);
                });
            });
    
            function copyToClipboard(text) {
                const textarea = document.createElement("textarea");
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand("copy");
                document.body.removeChild(textarea);
                alert("Account number copied to clipboard: " + text);
            }
        });
    </script>
    
        
</body>

</html>
