@extends('admin.layout.app')
@section('pageTitle', 'Edit Data Plan')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Data Plan</h5>
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

                        <form id="editDataPlanForm" action="{{ route('data-plans.update', $dataPlan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Network -->
                            <div class="row mb-3">
                                <label for="network" class="col-md-2 col-form-label">Network</label>
                                <div class="col-md-10">
                                    <select class="form-select" id="network" name="network_name">
                                        <option value="mtn" {{ $dataPlan->network_name == 'mtn' ? 'selected' : '' }}>MTN</option>
                                        <option value="airtel" {{ $dataPlan->network_name == 'airtel' ? 'selected' : '' }}>Airtel</option>
                                        <option value="glo" {{ $dataPlan->network_name == 'glo' ? 'selected' : '' }}>Glo</option>
                                        <option value="9mobile" {{ $dataPlan->network_name == '9mobile' ? 'selected' : '' }}>9mobile</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Plan ID -->
                            <div class="row mb-3">
                                <label for="plan_id" class="col-md-2 col-form-label">Plan ID</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="plan_id" name="plan_id" value="{{ $dataPlan->plan_id }}">
                                </div>
                            </div>

                            <!-- Provider -->
                            <div class="row mb-3">
                                <label for="provider" class="col-md-2 col-form-label">Data Plan Provider</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="provider" name="provider_id" value="{{ $dataPlan->provider_id }}">
                                </div>
                            </div>

                            <!-- Buying Price -->
                            <div class="row mb-3">
                                <label for="buying_price" class="col-md-2 col-form-label">Buying Price</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="buying_price" name="buying_price" value="{{ $dataPlan->buying_price }}">
                                </div>
                            </div>

                            <!-- Selling Price -->
                            <div class="row mb-3">
                                <label for="selling_price" class="col-md-2 col-form-label">Selling Price</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="selling_price" name="selling_price" value="{{ $dataPlan->selling_price }}">
                                </div>
                            </div>

                            <!-- Validity -->
                            <div class="row mb-3">
                                <label for="validity" class="col-md-2 col-form-label">Validity</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="validity" name="validity" value="{{ $dataPlan->validity }}">
                                </div>
                            </div>

                            <!-- Plan Type -->
                            <div class="row mb-3">
                                <label for="plan_type" class="col-md-2 col-form-label">Plan Type</label>
                                <div class="col-md-10">
                                    <select class="form-select" id="plan_type" name="plan_type">
                                        <option value="sme" {{ $dataPlan->plan_type == 'sme' ? 'selected' : '' }}>SME</option>
                                        <option value="gifting" {{ $dataPlan->plan_type == 'gifting' ? 'selected' : '' }}>Gifting</option>
                                        <option value="corporate gifting" {{ $dataPlan->plan_type == 'corporate gifting' ? 'selected' : '' }}>Corporate Gifting</option>
                                        <option value="sme2" {{ $dataPlan->plan_type == 'sme2' ? 'selected' : '' }}>SME2</option>
                                        <option value="airtime" {{ $dataPlan->plan_type == 'airtime' ? 'selected' : '' }}>Airtime</option>
                                    </select>                                    
                                </div>
                            </div>

                            <!-- Order Number -->
                            <div class="row mb-3">
                                <label for="order_number" class="col-md-2 col-form-label">Order Number</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="order_number" name="order_number" value="{{ $dataPlan->order_number }}">
                                </div>
                            </div>

                            <!-- Active -->
                            <div class="row mb-3">
                                <label for="active" class="col-md-2 col-form-label">Active</label>
                                <div class="col-md-10">
                                    <input type="checkbox" id="active" name="active" {{ $dataPlan->active ? 'checked' : '' }}>
                                </div>
                            </div>

                            <button type="submit" id="submitEditDataPlan" class="btn btn-primary">Save changes</button>

            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
