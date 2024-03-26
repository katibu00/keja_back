@extends('layout.app')
@section('pageTitle', 'Wallet')
@section('content')

    <div class="page-content-wrapper py-3">
        
        

        <div class="container mb-3">
            <div class="card bg-primary bg-img" style="background-image: url('/frontend/img/core-img/2.png')">
                <div class="card-body p-5 direction-rtl">
                    <svg class="bi bi-cpu text-white mb-3" width="48" height="48" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2A2.5 2.5 0 0 1 14 4.5h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14a2.5 2.5 0 0 1-2.5 2.5v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14A2.5 2.5 0 0 1 2 11.5H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2A2.5 2.5 0 0 1 4.5 2V.5A.5.5 0 0 1 5 0zm-.5 3A1.5 1.5 0 0 0 3 4.5v7A1.5 1.5 0 0 0 4.5 13h7a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 11.5 3h-7zM5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3zM6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"></path>
                    </svg>
                    <h2 class="text-white">Wallet Balance</h2>
                    <p class="text-white mb-2">Your current wallet balance:</p>
                    <h1 class="text-white display-4"> &#8358;{{ auth()->user()->wallet ? number_format(auth()->user()->wallet->main_balance, 2) : 'N/A' }}</h1>
                </div>
            </div>
        </div>
        




      <div class="container">
        <div class="card bg-primary rounded-0 rounded-top">
            <div class="card-body text-center py-3">
              <h6 class="mb-0 text-white line-height-1">Fund Your Wallet</h6>
            </div>
          </div>
        <div class="card">
          <div class="card-body">
            <div class="accordion accordion-style-three" id="accordionStyle3">
              <!-- Single Accordion -->
              <div class="accordion-item">
                <div class="accordion-header" id="accordionSeven">
                  <h6 class="shadow-sm rounded border" data-bs-toggle="collapse" data-bs-target="#accordionStyleSeven" aria-expanded="true" aria-controls="accordionStyleSeven">Reserved Account Numbers
                    <svg class="bi bi-arrow-down-short" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"></path>
                    </svg>
                  </h6>
                </div>
                <div class="accordion-collapse collapse show" id="accordionStyleSeven" aria-labelledby="accordionSeven" data-bs-parent="#accordionStyle3">
                  <div class="accordion-body">

                    <div class="standard-tab">
                        <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
                            @foreach($accounts as $index => $account)
                            <li class="nav-item" role="presentation">
                                <button class="btn {{ $index === 0 ? 'active' : '' }}" id="account-tab-{{ $index }}" data-bs-toggle="tab" data-bs-target="#account-{{ $index }}" type="button" role="tab" aria-controls="account-{{ $index }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $account['bankName'] }}</button>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
                            @foreach($accounts as $index => $account)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="account-{{ $index }}" role="tabpanel" aria-labelledby="account-tab-{{ $index }}">
                                <h6>{{ $account['bankName'] }}</h6>
                                <p class="mb-0">Account Number: {{ $account['accountNumber'] }}</p>
                                <p class="mb-0">Account Name: {{ $account['accountName'] }}</p>
                                <p class="mb-0">Charges: 1%</p>
                                <button class="btn btn-sm btn-primary copy-btn" data-clipboard-text="{{ $account['accountNumber'] }}" type="button"><i class="bi bi-clipboard"></i> Copy Account Number</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                  </div>
                </div>
              </div>
              <!-- Single Accordion -->
              <div class="accordion-item">
                <div class="accordion-header" id="accordionEight">
                    <h6 class="shadow-sm rounded collapsed border" data-bs-toggle="collapse" data-bs-target="#accordionStyleEight" aria-expanded="false" aria-controls="accordionStyleEight">
                        Paystack
                        <svg class="bi bi-arrow-down-short" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"></path>
                        </svg>
                    </h6>
                </div>
                <div class="accordion-collapse collapse" id="accordionStyleEight" aria-labelledby="accordionEight" data-bs-parent="#accordionStyle3">
                    <div class="accordion-body">
                        <form id="paystackForm">
                            <div class="mb-3">
                                <label for="amountInput" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amountInput" name="amount">
                            </div>
                            <button type="submit" class="btn btn-primary">Fund Wallet</button>
                        </form>
                        {{-- <p class="mb-0 mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam, a cupiditate.</p> --}}
                    </div>
                </div>
            </div>
            
              <!-- Single Accordion -->
              <div class="accordion-item">
                <div class="accordion-header" id="accordionNine">
                    <h6 class="shadow-sm rounded collapsed border" data-bs-toggle="collapse" data-bs-target="#accordionStyleNine" aria-expanded="false" aria-controls="accordionStyleNine">
                        Manual Bank Transfer 
                        <svg class="bi bi-arrow-down-short" width="24" height="24" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"></path>
                        </svg>
                    </h6>
                </div>
                <div class="accordion-collapse collapse" id="accordionStyleNine" aria-labelledby="accordionNine" data-bs-parent="#accordionStyle3">
                    <div class="accordion-body">
                        <p class="mb-3">Please transfer your desired amount to the following account:</p>
                        <p class="mb-1"><strong>Bank Name:</strong> Example Bank</p>
                        <p class="mb-1"><strong>Account Number:</strong> <span id="accountNumber">1234567890</span> <button class="btn btn-sm btn-secondary" onclick="copyText('accountNumber')">Copy Account Number</button></p>
                        <p class="mb-1"><strong>Account Name:</strong> John Doe</p>
                        <p class="mb-3"><strong>Reference:</strong> Please use your username as the description/reference when making the transfer.</p>
                        <p class="mb-0"><strong>Username:</strong> <span id="username">YourUsername</span> <button class="btn btn-sm btn-secondary" onclick="copyText('username')">Copy Username</button></p>
                    </div>
                </div>
            </div>
          
            </div>
          </div>
        </div>
      </div>





    
    </div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script>
    var clipboard = new ClipboardJS('.copy-btn');

    clipboard.on('success', function(e) {
        toastr.success('Account number copied to clipboard: ' + e.text);
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Failed to copy account number to clipboard: ' + e.text);
        toastr.error('Failed to copy account number to clipboard');
    });
    function copyText(elementId) {
    var text = document.getElementById(elementId).innerText;

    var tempInput = document.createElement("input");
    tempInput.value = text;
    document.body.appendChild(tempInput);

    tempInput.select();
    tempInput.setSelectionRange(0, 99999); /* For mobile devices */

    document.execCommand("copy");
    document.body.removeChild(tempInput);

    // Show a toastr or other message to indicate successful copying
    toastr.success('Text copied to clipboard!');
}

</script>



{{-- <script src="https://js.paystack.co/v1/inline.js"></script> --}}
<script src="/paystack.js"></script>

<script>

    $('#paystackForm').submit(function(event) {
        event.preventDefault();
        payWithPaystack();
     });        
    function payWithPaystack() {
        // Retrieve course price and ID from hidden fields
        var amount = document.querySelector('[name="amount"]').value.trim();
       
        // Check if the course price is empty or not a valid number
        if (amount === "" || isNaN(amount) || amount < 100) {
            // Display validation error using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount!',
                text: 'Please enter a valid amount before proceeding.',
            });
            return;
        }

        var user_id = '{{ auth()->user()->id }}';

        var handler = PaystackPop.setup({
            key: '{{ $publicKey }}',
            email: '{{ auth()->user()->email }}',
            amount: amount * 100,
            currency: 'NGN',
            metadata: {
                user_id: user_id, 
            },
            callback: function(response) {
                // Make an AJAX call to your server with the reference to verify the transaction
                var reference = response.reference;
                $.post('/wallet/verify-payment', {reference: reference, _token: '{{ csrf_token() }}'}, function(data) {
                    if(data.success) {
                        // Display success message using SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: data.message, // Display message received from the server
                        }).then((result) => {
                            // Reload the page after displaying the message
                            window.location.href = "{{ route('wallet.index') }}?message=Payment+successful";
                        });
                    } else {
                        // Display failure message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Failed!',
                            text: data.message, // Display message received from the server
                        });
                    }
                });
            },

            onClose: function() {
                // Display message for closed transaction using SweetAlert
                Swal.fire({
                    icon: 'warning',
                    title: 'Transaction Not Completed!',
                    text: 'Transaction was not completed, window closed.',
                });
            },
        });
        handler.openIframe();
    }
</script>
@endsection
