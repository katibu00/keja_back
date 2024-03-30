@extends('admin.layout.app')
@section('pageTitle', 'Data Plans')
<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title">Data Plans</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataPlanModal">
                                Add Data Plans
                            </button>
                        </div> --}}
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h5 class="card-title">Data Plans</h5>
                                </div>
                                <div class="col-lg-6 mt-3 mt-lg-0">
                                    <div class="row align-items-center justify-content-end">
                                        <div class="col-md mb-2 mb-md-0">
                                            <select class="form-select filter-network" aria-label="Filter by Network">
                                                <option value="">All Networks</option>
                                                <option value="mtn">MTN</option>
                                                <option value="airtel">Airtel</option>
                                                <option value="glo">Glo</option>
                                                <option value="9mobile">9mobile</option>
                                            </select>
                                        </div>
                                        <div class="col-md mb-2 mb-md-0">
                                            <select class="form-select filter-plan-type" aria-label="Filter by Plan Type">
                                                <option value="">All Plan Types</option>
                                                <option value="sme">SME</option>
                                                <option value="gifting">Gifting</option>
                                                <option value="corporate gifting">Corporate Gifting</option>
                                                <option value="sme2">SME2</option>
                                                <option value="airtime">Airtime</option>
                                            </select>
                                        </div>
                                        <div class="col-md-auto">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDataPlanModal">
                                                Add New Data Plans
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        
                            <div class="table-responsive text-nowrap">
                               @include('data_plans.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Data Plan Modal -->
<div class="modal fade" id="addDataPlanModal" tabindex="-1" aria-labelledby="addDataPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded shadow-none mb-0">
                <div class="block-header block-header-default">
                    <h5 class="block-title" id="addDataPlanModalLabel">Add Data Plan</h5>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <span class="bi bi-x"></span>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm my-3">
                    <!-- Form for adding new data plan -->
                    <form id="addDataPlanForm" action="{{ route('data-plans.store') }}" method="post">
                        @csrf                      
                        <!-- Fixed fields in one horizontal row -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="network" class="form-label">Network</label>
                                <select class="form-select" id="network" name="network">
                                    <option value="mtn">MTN</option>
                                    <option value="airtel">Airtel</option>
                                    <option value="glo">Glo</option>
                                    <option value="9mobile">9mobile</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="data_plan_type" class="form-label">Data Plan Type</label>
                                <select class="form-select" id="data_plan_type" name="data_plan_type">
                                    <option value="sme">SME</option>
                                    <option value="gifting">Gifting</option>
                                    <option value="corporate gifting">Corporate Gifting</option>
                                    <option value="sme2">SME2</option>
                                    <option value="airtime">Airtime</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="provider" class="form-label">Data Plan Provider</label>
                                <select class="form-select" id="provider" name="provider">
                                        <option value=""></option>
                                    @foreach ($PlanProviders as $PlanProvider)
                                        <option value="{{ $PlanProvider->id }}">{{ $PlanProvider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Dynamic fields -->
                        <div id="dynamicFields">
                            <!-- Dynamic fields will be added here using JavaScript -->
                        </div>

                        <!-- Add and remove dynamic fields -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
                            <button type="button" class="btn btn-danger" id="removeRow">Remove Row</button>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submitAddDataPlan" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // JavaScript for adding and removing dynamic fields
        $(document).ready(function() {
            $('#addRow').click(function() {
                // Add a new row of dynamic fields
                $('#dynamicFields').append('<div class="row mb-2">' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Plan ID" name="plan_id[]"></div>' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Amount" name="amount[]"></div>' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Buying Price" name="buying_price[]"></div>' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Selling Price" name="selling_price[]"></div>' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Order Number" name="order_number[]"></div>' +
                    '<div class="col-md-2"><input type="text" class="form-control" placeholder="Validity" name="validity[]"></div>' +
                    '</div>');
            });

            $('#removeRow').click(function() {
                // Remove the last row of dynamic fields
                $('#dynamicFields .row:last').remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.filter-network, .filter-plan-type').on('change', function() {
                var network = $('.filter-network').val().toLowerCase();
                var planType = $('.filter-plan-type').val().toLowerCase();

                $('table tbody tr').each(function() {
                    var $row = $(this);
                    var rowNetwork = $row.find('td:eq(0)').text().toLowerCase(); // Assuming network is in the first column
                    var rowPlanType = $row.find('td:eq(7)').text().toLowerCase(); // Assuming plan type is in the eighth column

                    if ((network === '' || rowNetwork === network) && (planType === '' || rowPlanType === planType)) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#addDataPlanForm').submit(function(e) {
                e.preventDefault();

                // Disable submit button and show loading spinner
                $('#submitAddDataPlan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...');

                // Serialize form data
                var formData = $(this).serialize();

                // AJAX request to submit form data
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    success: function(response) {

                        $('#submitAddDataPlan').prop('disabled', false).html('Submit');
                        $('.table').load(location.href+' .table');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Reset form fields
                        $('#addDataPlanForm')[0].reset();

                        // Close modal
                        $('#addDataPlanModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                    // Enable the submit button
                    $('#submitAddDataPlan').prop('disabled', false).html('Submit');

                    // Check if validation errors exist
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Extract validation errors
                        var errors = xhr.responseJSON.errors;

                        // Construct error message
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });

                        // Display error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessage,
                        });
                    } else {
                        // Display generic error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                }

                });
            });
        });
    </script>

@endsection
