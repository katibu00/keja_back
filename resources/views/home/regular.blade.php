@extends('layout.app')
@section('pageTitle', 'Home')
@section('content')

    <div class="page-content-wrapper">

        <div class="pt-3"></div>

        <div class="container direction-rtl">
            <div class="card mb-3 text-center">
                {{-- <div class="card-header bg-primary text-white">
            <h4 class="my-0">User Balance</h4>
          </div> --}}
          <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-wallet2 me-3"></i>Main Balance
                            </h5>
                            <p id="main-balance" class="card-text display-6">₦{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->main_balance, 2) : 'N/A' }}</p>
                            <!-- Add funds button -->
                            <a href="{{ route('wallet.index') }}" class="btn btn-primary btn-sm">Add Funds</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-gift me-3"></i>Bonus Balance
                            </h5>
                            <p id="bonus-balance" class="card-text display-6">{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->bonus_balance, 2) : 'N/A' }} MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                {{-- <div class="card-footer text-muted">
                    Updated just now
                </div> --}}
            </div>
        </div>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="row g-3">
                        <div class="col-4">
                            <a href="{{ route('recent.transactions') }}" class="text-decoration-none">
                                <div class="feature-card mx-auto">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-arrow-left-right me-3"></i>
                                    </div>
                                    <p class="mb-0">Transactions</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="https://wa.me/2348033174228?text=My%20name%20is" target="_blank" rel="noopener noreferrer">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-whatsapp me-3"></i>
                                    </div>
                                    <p class="mb-0">WhatsApp us</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-box-arrow-right me-3"></i>
                                    </div>
                                    <p class="mb-0">Logout</p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- New Menu Icons -->
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="#buydata">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-file-earmark-bar-graph me-3"></i>
                                    </div>
                                    <p class="mb-0">Buy Data</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto">
                                <a href="{{ route('pricing.plans') }}">
                                    <div class="card mx-auto bg-gray">
                                        <i class="mx-auto bi bi-cash me-3"></i>
                                    </div>
                                    <p class="mb-0">Pricing Plans</p>
                                </a>
                            </div>
                        </div>
                        <!-- End of New Menu Icons -->
                    </div>
                </div>
            </div>
        </div>



        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="row g-3">
                        @if($marqueeNotification)
                        <marquee class="marquee-notification" behavior="scroll" direction="left">
                            {{ $marqueeNotification->message }}
                        </marquee>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        

        <style>
            .marquee-notification {
                font-size: 1.2em;
                font-weight: bold;
                color: #d63384;
                padding: 10px;
                /* background-color: #e9ecef;  */
                border-radius: 8px;
            }
            .bonus-container {
                background-color: #f0f0f0;
                border-radius: 5px;
                padding: 10px;
                font-weight: bold;
            }

        </style>

        <div class="container">
            <div class="card mb-3">
                 <div class="card-header bg-primary text-white">
            <h4 class="my-0 text-white">Buy Data</h4>
          </div>
                <div class="card-body">
                    <span id="buydata"></span>
                    <form id="buy_data_form">
                        <input type="hidden" id="bonusPerGB" value="{{ $bonusPerGB }}">

                        <div class="form-group mb-">
                            <label class="form-label">Network</label>
                            <select class="form-select" id="network">
                                <option value=""></option>
                                <option value="MTN">MTN</option>
                                <option value="AIRTEL">AIRTEL</option>
                                <option value="GLO">GLO</option>
                                <option value="9MOBILE">9MOBILE</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Recipient</label>
                            <select class="form-select" id="contact" name="contact">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="form-group" id="phoneField" style="display: none;">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="number">
                            <div class="form-check mt-2 d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" id="bypassValidator">
                                <label class="form-check-label mb-0" for="bypassValidator">Bypass Number Validator</label>
                            </div>                            
                        </div>

                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <select class="form-select" id="amount" name="amount">
                                <option value=""></option>
                            </select>
                        </div>
                        <div id="bonusSection" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Bonus</label>
                                <div class="bonus-container" id="bonusContainer"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" disabled>
                        </div>

                        <button class="btn btn-success w-100">Buy Now</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="pb-3"></div>

        <div class="container">
            <div class="card bg-primary mb-3 bg-img" style="background-image: url('img/core-img/1.png')">
                <div class="card-body direction-rtl p-5">
                    <h2 class="text-white">Referral Program</h2>
                    <p class="mb-4 text-white">Share your referral link with your contacts and get 1GB for every referral!</p>
                    <div class="mb-3">
                        <strong class="text-white">Your Referral Link:</strong>
                        <input type="text" id="referralLink" class="form-control" value="{{ route('register') }}?referral_code={{ auth()->user()->referral_code }}" readonly>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success" onclick="shareOnWhatsApp()">Share on WhatsApp</button>
                        <button class="btn btn-info" onclick="copyLink()">Copy Link</button>
                    </div>
                    <div>
                        <strong class="text-white">Total Users Referred:</strong>
                        <span class="text-white">{{ auth()->user()->referredUsers()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="pb-3"></div>

    </div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script>
   function shareOnWhatsApp() {

    var leadingMessage = "Join SubNow, Nigeria's premier destination for hassle-free data and airtime purchases! Unlock exclusive bonuses on every data package you buy when you sign up using my referral link. Don't miss out on the convenience and savings – open an account now and start enjoying the perks!\n\n";
        var referralLink = document.getElementById('referralLink').value;
        var shareMessage = leadingMessage + referralLink;

        var shareURL = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(shareMessage);

        window.open(shareURL, '_blank');
    }


    function copyLink() {

        var referralLinkInput = document.getElementById('referralLink');
        referralLinkInput.select();
        referralLinkInput.setSelectionRange(0, 99999); 

        document.execCommand('copy');

        referralLinkInput.setSelectionRange(0, 0);

        toastr.success('Referral link copied to clipboard!');
    }
</script>


<script>
     // Function to show or hide the phone number field based on recipient selection
document.getElementById('contact').addEventListener('change', function () {
    var selectedRecipient = this.value;
    var phoneField = document.getElementById('phoneField');
    if (selectedRecipient === 'new_number') {
        phoneField.style.display = 'block';
    } else {
        phoneField.style.display = 'none';
    }
});

// Function to validate the phone number based on the selected network
document.getElementById('number').addEventListener('input', function () {
    var phoneNumber = this.value;
    var network = document.getElementById('network').value;
    var networkCodes = {
        'MTN': ['0803', '0806', '0703', '0903', '0906', '0806', '0706', '0813', '0810', '0814', '0816', '0913', '0916'],
        'GLO': ['0805', '0705', '0905', '0807', '0815', '0811', '0915'],
        'AIRTEL': ['0802', '0902', '0701', '0808', '0708', '0812', '0901', '0907'],
        '9MOBILE': ['0809', '0909', '0817', '0818', '0908']
    };

    if (phoneNumber.length >= 4) {
        var code = phoneNumber.substring(0, 4);
        if (networkCodes[network] && !networkCodes[network].includes(code)) {
            // Number doesn't match network code, warn user
            if (!document.getElementById('bypassValidator').checked) {
                Swal.fire('Error', 'The phone number does not match the selected network code. Please verify or check the "Bypass Number Validator"  for ported number.', 'error');
                document.getElementById('number').value = '';
            }
        }
    }
});

</script>

    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
   

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

            @if ($popUp)
                setTimeout(function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Notification',
                        html: '{{ $popUp->body }}',
                        confirmButtonText: 'Close',
                        allowOutsideClick: false,
                        timer: 10000, 
                        timerProgressBar: true, 
                        willClose: () => {
                            
                        }
                    });
                }, 2000); 
             @endif


            $('#network').on('change', function() {
                var networkId = $(this).val();
                var amountField = $('#amount');
                var contactsField = $('#contact');
                var numberField = $('#number');
                var priceField = $('#price');

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
                            numberField.val(''); 
                            priceField.val('');
                           
                            var dataPlans = response.dataPlans;
                            var contacts = response.contacts;
                            var dataPlansHTML = '';
                            dataPlansHTML += '<option value=""></option>'
                            $.each(dataPlans, function(index, dataPlan) {
                                dataPlansHTML += '<option value="' + dataPlan.plan_id + '" data-plan_price="' + dataPlan.selling_price + '" data-plan_amount="' + dataPlan.amount + '">' + dataPlan.amount + ' - ' + dataPlan.plan_type.toUpperCase() + ' - N' + dataPlan.selling_price + '</option>';
                            });
                            amountField.html(dataPlansHTML);
                            var contactHTML = '';
                            contactHTML += '<option value=""></option><option value="new">New Number</option>'
                            $.each(contacts, function(index, contact) {
                                contactHTML += '<option value="' + contact.number + '" data-contact_number="' + contact.number + '">' + contact.name + ' (' + contact.network + ' - ' + contact.number + ')</option>';
                            });
                            contactsField.html(contactHTML);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });


            $('#amount').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var bonusPerGB = parseInt($('#bonusPerGB').val());

                if (selectedOption.val() !== '') {
                    var planAmount = selectedOption.data('plan_amount');
                    var numericAmount = parseFloat(planAmount);
                    var isGB = planAmount.toLowerCase().includes('gb');

                    if (!isGB) {
                        // Convert MB to GB
                        numericAmount /= 1024;
                    }

                    var bonus = numericAmount * bonusPerGB;
                    bonus = Math.round(bonus * 100) / 100;

                    // Display bonus section and style creatively
                    $('#bonusContainer').html(bonus + ' MB Bonus');
                    $('#bonusSection').show();
                } else {
                    // Hide bonus section if no amount selected
                    $('#bonusSection').hide();
                }
            });


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

                var formData = {
                    network: network,
                    contact: contact,
                    number: number,
                    plan_id: amount,
                    price: price,
                    selectedContactNumber: selectedContactNumber,
                    selectedPlanPrice: selectedPlanPrice
                };

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to buy ' + selectedPlanAmount + ` for \u20a6` + price,
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
                                if (res.status === 200) {
                                    Swal.fire('Success', res.message, 'success').then((result) => {
                                        
                                        if (!isNaN(res.new_wallet_balance)) {
                                            $('#main-balance').text('₦' + parseFloat(res.new_wallet_balance).toFixed(2));
                                        } else {
                                            console.error("Invalid new_wallet_balance:", res.new_wallet_balance);
                                        }

                                        if (!isNaN(res.new_bonus_balance)) {
                                            // Assuming '#bonus-balance' is the ID of the element displaying bonus balance
                                            $('#bonus-balance').text(res.new_bonus_balance + ' MB');
                                        } else {
                                            console.error("Invalid new_bonus_balance:", res.new_bonus_balance);
                                        }
            
                                        if (result.isConfirmed && formData.contact === 'new') {
                                            Swal.fire({
                                                title: 'Save New Beneficiary?',
                                                html: '<input id="contactName" class="swal2-input" placeholder="Beneficiary Name">',
                                                preConfirm: function() {
                                                    return {
                                                        contactName: $('#contactName').val()
                                                    };
                                                },
                                                showCancelButton: true,
                                                confirmButtonText: 'Save',
                                                cancelButtonText: 'Cancel',
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    
                                                    var contactName = result.value.contactName;

                                                    var newContactData = {
                                                        name: contactName,
                                                        number: formData.number,
                                                        network: formData.network
                                                    };

                                                    $.ajax({
                                                        url: '/save-contact',
                                                        method: 'POST',
                                                        data: newContactData,
                                                        success: function(response) {
                                                     
                                                            if (response.status === 200) {
                                                                Swal.fire('Success', response.message, 'success');
                                                            } else {
                                                                Swal.fire('Error',response.message, 'error');
                                                            }
                                                        },
                                                        error: function(xhr, status, error ) {
                                                            // Handle the error response if needed
                                                            console.log(error);
                                                            Swal.fire('Error','An error occurred while saving the contact', 'error');
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                    JsLoadingOverlay.hide();
                                } else if (res.status === 400) {
                                    Swal.fire('Error', res.message, 'error');
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
