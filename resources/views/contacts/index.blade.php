@extends('layout.app')
@section('pageTitle', 'Beneficiaries')
@section('content')


    <div class="add-new-contact-modal modal fade px-0" id="addnewcontact" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="modal-title" id="addnewcontactlabel">New Beneficiary</h6>
                        <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form id="contactForm">

                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Number</label>
                            <input type="number" class="form-control" id="number" name="number">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Network</label>
                            <select class="form-select" id="network" name="network">
                                <option value=""></option>
                                <option value="MTN">MTN</option>
                                <option value="AIRTEL">AIRTEL</option>
                                <option value="GLO">GLO</option>
                                <option value="9MOBILE">9MOBILE</option>
                            </select>
                        </div>
                        <button id="submitBtn" class="btn btn-primary w-100" type="submit">Save Beneficiary</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="update-contact-modal modal fade px-0" id="updatecontact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatecontactlabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                      <h6 class="modal-title" id="updatecontactlabel">Update Beneficiary</h6>
                      <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
  
                  <form id="updateContactForm">
                      <input type="hidden" id="contactId" name="contactId">
                      <div class="form-group">
                          <label class="form-label">Name</label>
                          <input type="text" class="form-control" id="updateName" name="name">
                      </div>
                      <div class="form-group">
                          <label class="form-label">Number</label>
                          <input type="number" class="form-control" id="updateNumber" name="number">
                      </div>
                      <div class="form-group">
                          <label class="form-label">Network</label>
                          <select class="form-select" id="updateNetwork" name="network">
                              <option value=""></option>
                              <option value="MTN">MTN</option>
                              <option value="AIRTEL">AIRTEL</option>
                              <option value="GLO">GLO</option>
                              <option value="9MOBILE">9MOBILE</option>
                          </select>
                      </div>
                      <button id="updateBtn" class="btn btn-primary w-100" type="button">Update Beneficiary</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  

    <div class="page-content-wrapper py-3">
        <!-- Add New Contact -->
        <div class="add-new-contact-wrap"><a class="shadow" href="#" data-bs-toggle="modal"
                data-bs-target="#addnewcontact"><i class="bi bi-plus-lg"></i></a></div>
        <div class="container">
            <div class="card mb-2">
                <div class="card-body p-2">
                    <div class="chat-search-box">
                        <form action="#">
                            <div class="input-group"><span class="input-group-text" id="searchbox"><i
                                        class="bi bi-search"></i></span>
                                <input class="form-control" type="search" placeholder="Search Beneficiaries"
                                    aria-describedby="searchbox">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Chat User List -->
            <ul class="ps-0 chat-user-list">
                @if (count($contacts) === 0)
                    <tr>
                        <td colspan="5" class="text-center">No contacts available</td>
                    </tr>
                @else
                    @foreach ($contacts as $key => $contact)
                        <!-- Single Chat User -->
                        <li class="p-3"><a class="d-flex" href="#">
                                <!-- Thumbnail -->
                                <div class="chat-user-thumbnail me-3 shaadow"><img class="img-circle"
                                        src="/{{ strtolower($contact->network) }}.png" alt=""></div>
                                <!-- Info -->
                                <div class="chat-user-info">
                                    <h6 class="text-truncate mb-0">{{ $contact->name }}</h6>
                                    <div class="last-chat">
                                        <p class="text-truncate mb-0">{{ $contact->number }}</p>
                                    </div>
                                </div>
                            </a>
                            <!-- Options -->
                            <div class="dropstart chat-options-btn">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#" class="edit-contact" data-id="{{ $contact->id }}" data-name="{{ $contact->name }}" data-number="{{ $contact->number }}" data-network="{{ $contact->network }}"><i class="bi bi-pencil"></i>Edit</a></li>
                                  <li><a href="#"><i class="bi bi-clock-history"></i>History</a></li>
                                    <li><a href="#" class="delete-contact" data-id="{{ $contact->id }}" data-name="{{ $contact->name }}"><i class="bi bi-trash"></i>Delete</a></li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

    @endsection
    @section('js')


    <script>
      $(document).ready(function() {
          $('.edit-contact').click(function(e) {
              e.preventDefault();
      
              var contactId = $(this).data('id');
              var contactName = $(this).data('name');
              var contactNumber = $(this).data('number');
              var contactNetwork = $(this).data('network');
      
              $('#contactId').val(contactId);
              $('#updateName').val(contactName);
              $('#updateNumber').val(contactNumber);
              $('#updateNetwork').val(contactNetwork);
      
              $('#updatecontact').modal('show');
          });
      
          $('#updateBtn').click(function() {
              var contactId = $('#contactId').val();
              var newName = $('#updateName').val();
              var newNumber = $('#updateNumber').val();
              var newNetwork = $('#updateNetwork').val();


              var $submitBtn = $('#updateBtn');
              var originalBtnContent = $submitBtn.html();
              $submitBtn.prop('disabled', true).html(
                  '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
                  );
      
              $.ajax({
                  type: 'POST',
                  url: '{{ route('contacts.update') }}',
                  data: {
                      _token: '{{ csrf_token() }}',
                      id: contactId,
                      name: newName,
                      number: newNumber,
                      network: newNetwork
                  },
                  success: function(response) {
                    $('#updatecontact').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: response.message,
                    }).then(() => {
                        location.reload();
                    });
                  },
                  error: function(xhr, status, error) {
                      console.error(xhr.responseText);
                      // Handle error response
                      // For example, show an error message
                      alert('An error occurred while updating the contact. Please try again later.');
                  }
              });
          });
      });
      </script>
      
        <script>
            $(document).ready(function() {
                $('.delete-contact').click(function(e) {
                    e.preventDefault();

                    // Get contact ID and name from data attributes
                    var contactId = $(this).data('id');
                    var contactName = $(this).data('name');

                    // Show confirmation dialog using SweetAlert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Contact',
                        text: 'Are you sure you want to delete ' + contactName + '?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed deletion, send AJAX request to delete contact
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('contacts.destroy') }}',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE',
                                    id: contactId
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Contact deleted successfully!',
                                    }).then(() => {
                                        // Reload the page after successful deletion
                                        location.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'An error occurred while deleting the contact. Please try again later.',
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $('#contactForm').submit(function(e) {
                    e.preventDefault();

                    var name = $('#name').val();
                    var number = $('#number').val();
                    var network = $('#network').val();

                    if (!name || !number || !network) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please fill in all fields!',
                        });
                        return;
                    }

                    var $submitBtn = $('#submitBtn');
                    var originalBtnContent = $submitBtn.html();
                    $submitBtn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
                        );

                    var formData = {
                        name: name,
                        number: number,
                        network: network
                    };

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('contacts.store') }}',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            $('#addnewcontact').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved',
                                text: response.message,
                            }).then(() => {
                                location.reload();
                            });
                            $('#contactForm')[0].reset();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while saving data. Please try again later.',
                            });
                        },
                        complete: function() {
                            $submitBtn.prop('disabled', false).html(originalBtnContent);
                        }
                    });
                });
            });
        </script>





        <script>
            $(document).ready(function() {
                $('#number').on('keyup', function() {
                    var number = $(this).val();
                    var prefix = number.substring(0, 4);
                    var network = '';

                    if (prefix == '0803' || prefix == '0806' || prefix == '0703' || prefix == '0903' ||
                        prefix == '0906' || prefix == '0806' || prefix == '0706' || prefix == '0813' ||
                        prefix == '0810' || prefix == '0814' || prefix == '0816' || prefix == '0913' ||
                        prefix == '0916') {
                        network = 'MTN';
                    } else if (prefix == '0805' || prefix == '0705' || prefix == '0905' || prefix == '0807' ||
                        prefix == '0815' || prefix == '0811' || prefix == '0915') {
                        network = 'GLO';
                    } else if (prefix == '0802' || prefix == '0902' || prefix == '0701' || prefix == '0808' ||
                        prefix == '0708' || prefix == '0812' || prefix == '0901' || prefix == '0907') {
                        network = 'AIRTEL';
                    } else if (prefix == '0809' || prefix == '0909' || prefix == '0817' || prefix == '0818' ||
                        prefix == '0908') {
                        network = '9MOBILE';
                    }

                    $('#network').val(network).change();
                });
                $('#updateNumber').on('keyup', function() {
                    var number = $(this).val();
                    var prefix = number.substring(0, 4);
                    var network = '';

                    if (prefix == '0803' || prefix == '0806' || prefix == '0703' || prefix == '0903' ||
                        prefix == '0906' || prefix == '0806' || prefix == '0706' || prefix == '0813' ||
                        prefix == '0810' || prefix == '0814' || prefix == '0816' || prefix == '0913' ||
                        prefix == '0916') {
                        network = 'MTN';
                    } else if (prefix == '0805' || prefix == '0705' || prefix == '0905' || prefix == '0807' ||
                        prefix == '0815' || prefix == '0811' || prefix == '0915') {
                        network = 'GLO';
                    } else if (prefix == '0802' || prefix == '0902' || prefix == '0701' || prefix == '0808' ||
                        prefix == '0708' || prefix == '0812' || prefix == '0901' || prefix == '0907') {
                        network = 'AIRTEL';
                    } else if (prefix == '0809' || prefix == '0909' || prefix == '0817' || prefix == '0818' ||
                        prefix == '0908') {
                        network = '9MOBILE';
                    }

                    $('#updateNetwork').val(network).change();
                });
            });
        </script>
    @endsection
