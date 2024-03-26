@extends('layout.app')
@section('pageTitle', 'Contact Us')
@section('content')

<div class="page-content-wrapper py-3">
    <div class="container">               
        <!-- Contact Form -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Write to us</h5>
                <div class="contact-form">
                    <form action="{{ route('contact_us.submit') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input class="form-control" type="text" name="name" placeholder="Your name" required>
                        </div>
                        <div class="form-group mb-3">
                            <input class="form-control" type="email" name="email" placeholder="Enter email (optional)">
                        </div>
                        <div class="form-group mb-3">
                            <select class="form-select" name="complaint" required>
                                <option value="">Select Complaint Type</option>
                                <option value="Funding Failure">Funding Failure</option>
                                <option value="Data Purchase Problem">Data Purchase Problem</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form-control" name="message" cols="30" rows="5" placeholder="Write details" required></textarea>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Send Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Other Contact Options -->
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Other Contact Options</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-whatsapp me-2"></i><a href="https://wa.me/2348033174228?text=Hello,%20I%20have%20a%20question." target="_blank">WhatsApp: +2348033174228</a></li>
                    <!-- Add phone number and email options -->
                    <li><i class="bi bi-telephone me-2"></i>Phone: +1234567890</li>
                    <li><i class="bi bi-envelope me-2"></i>Email: info@example.com</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
