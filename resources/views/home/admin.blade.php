@extends('layout.app')
@section('PageTitle', 'Home')
@section('content')
<style>
    .owl-carousel {
        margin: 0;
        padding: 0;
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: none;
        scrollbar-width: none;
        z-index: 10000;
    }
    
    .owl-carousel::-webkit-scrollbar {
        display: none;
    }
    
    .owl-carousel .owl-item {
        flex: 0 0 auto;
        width: 100%;
        padding: 0;
        margin-right: 0;
    }
</style>


    <section class="" style="margin-top: 20px;">
        <div class="container">
            <div class="row">

                <div class="col-md-7 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <marquee>Make a transfer to any of the account numbers below and wait few minutes and refresh
                                this page</marquee>
                        </div>
                        <div class="card-body">
                            <div class="horizontal-scroll">

                                <div id="account-carousel" class="owl-carousel">
                                    {{-- @if (is_array($accounts) && count($accounts) > 0)
                                        @foreach ($accounts as $account)
                                            <div class="account-card">
                                                <h6>{{ $account['bankName'] }}</h6>
                                                <p>{{ $account['accountNumber'] }}</p>
                                                <p>{{ $account['accountName'] }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="account-card">
                                            <h6>No Account Numbers</h6>
                                            <p></p>
                                            <p></p>
                                        </div>
                                    @endif --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <ul class="list-group mb-2">
                        <li class="list-group-item">
                            Your Wallet Balance:
                            <span class="badge bg-secondary float-end"
                                style="margin-top: 3px;">&#8358;{{ number_format(auth()->user()->wallet->balance) }}</span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Your Bonus Points:
                            <span class="badge bg-secondary float-end"
                                style="margin-top: 3px;">{{ number_format(auth()->user()->wallet->balance) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="data-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Buy Data Quickly</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group text-left">
                                    <label for="network">Network:</label>
                                    <select class="form-select" id="network">
                                        <option value=""></option>
                                        <option value="MTN">MTN</option>
                                        <option value="AIRTEL">AIRTEL</option>
                                        <option value="GLO">GLO</option>
                                        <option value="9MOBILE">9MOBILE</option>
                                    </select>
                                </div>
                                <div class="form-group text-left">
                                    <label for="contact">Number:</label>
                                    <select class="form-select" id="contact" name="contact">
                                    </select>
                                </div>
                                <div class="form-group text-left" id="phoneField" style="display: none;">
                                    <label for="number">Phone Number:</label>
                                    <input type="text" class="form-control" id="number">
                                </div>
                                <div class="form-group text-left">
                                    <label for="amount">Select Amount:</label>
                                    <select class="form-select" id="amount">
                                    </select>
                                </div>
                                <div class="form-group text-left">
                                    <label for="price">Price:</label>
                                    <input type="text" class="form-control" id="price" disabled>
                                </div>
                                <button type="submit" class="btn btn-primary">Buy Data</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Transactions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Network</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2023-05-28</td>
                                            <td>Network 1</td>
                                            <td>1GB</td>
                                            <td>Successful</td>
                                        </tr>
                                        <tr>
                                            <td>2023-05-27</td>
                                            <td>Network 2</td>
                                            <td>500MB</td>
                                            <td>Failed</td>
                                        </tr>
                                        <tr>
                                            <td>2023-05-26</td>
                                            <td>Network 3</td>
                                            <td>2GB</td>
                                            <td>Successful</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   


@endsection
@section('js')
   

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                dots: true,
                navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                mouseDrag: true,
                touchDrag: true,
                autoWidth: false,
                responsive: {
                    0: {
                        items: 1,
                       
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                },
               
            });
        });
    </script>
    
    
    



    <script>
        $(document).ready(function() {
            $('#contact').on('change', function() {
                var phoneField = $('#phoneField');
                if ($(this).val() === 'new') {
                    phoneField.show();
                } else {
                    phoneField.hide();
                }
            });
            $('#amount').on('change', function() {

                var planPrice = $(this).find('option:selected').data('plan_price');
                $('#price').val(planPrice);

            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#network').on('change', function() {
                var networkId = $(this).val();
                var amountField = $('#amount');
                var contactsField = $('#contact');

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                amountField.html('<option value="">Loading...</option>');
                contactsField.html('<option value="">Loading...</option>');

                if (networkId) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: '/fetch-data-plans',
                        method: 'POST',
                        data: {
                            networkId: networkId
                        },
                        success: function(response) {
                            amountField.empty();
                            contactsField.empty();
                            var dataPlans = response.dataPlans;
                            var contacts = response.contacts;
                            var dataPlansHTML = '';
                            dataPlansHTML += '<option value=""></option>'
                            $.each(dataPlans, function(index, dataPlan) {
                                dataPlansHTML += '<option value="' + dataPlan.plan_id +
                                    '" data-plan_price="' + dataPlan.selling_price +
                                    '" data-plan_amount="' + dataPlan.amount +
                                    '">' + dataPlan.amount + '</option>';
                            });
                            amountField.html(dataPlansHTML);
                            var contactHTML = '';
                            contactHTML +=
                                '<option value=""></option><option value="new">New Number</option>'
                            $.each(contacts, function(index, contact) {
                                contactHTML += '<option value="' + contact.number +
                                    '" data-contact_number="' + contact.number + '">' +
                                    contact.name + ' (' + contact.network + ' - ' +
                                    contact.number + ')</option>';
                            });
                            contactsField.html(contactHTML);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });


            //////////



            $('form').on('submit', function(e) {
                e.preventDefault();

                var network = $('#network').val();
                var contact = $('#contact').val();
                var number = $('#number').val();
                var amount = $('#amount').val();
                var price = $('#price').val();
                var selectedContactNumber = $('#contact option:selected').data('contact_number');
                var selectedPlanPrice = $('#amount option:selected').data('plan_price');
                var selectedPlanAmount = $('#amount option:selected').data('plan_amount');

                if (!network) {
                    Swal.fire('Error', 'Please select a network', 'error');
                    return;
                }
                if (!contact) {
                    Swal.fire('Error', 'Please select a recipient', 'error');
                    return;
                }

                if (contact === 'new' && number === '') {
                    Swal.fire('Error', 'Please fill in the recipient phone number', 'error');
                    return;
                }
                if (!amount) {
                    Swal.fire('Error', 'Please select an amount', 'error');
                    return;
                }

                // Create an object with the form data
                var formData = {
                    network: network,
                    contact: contact,
                    number: number,
                    amount: amount,
                    price: price,
                    selectedContactNumber: selectedContactNumber,
                    selectedPlanPrice: selectedPlanPrice
                };

                // Show the confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to buy '+selectedPlanAmount+` for \u20a6`+price,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        JsLoadingOverlay.show();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/buy-data-plans',
                            method: 'POST',
                            data: formData,
                            success: function(res) {
                               
                                // Example: Swal.fire('Success', 'Action completed successfully', 'success');
                                if(res.status === 200)
                                {
                                    Swal.fire('Success', res.message, 'success');
                                    JsLoadingOverlay.hide();
                                }
                                if(res.status === 400)
                                {
                                    Swal.fire('error', res.message, 'error');
                                    JsLoadingOverlay.hide();
                                }

                            },
                            error: function(xhr, status, error) {
                                // Handle the error response if needed
                                // Example: Swal.fire('Error', 'An error occurred', 'error');
                            }
                        }).always(function() {
                            // JsLoadingOverlay.hide();
                        });
                    }
                });
            });




        });
    </script>
@endsection
