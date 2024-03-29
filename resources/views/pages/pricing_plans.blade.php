
@extends('layout.app')

@section('pageTitle', 'Pricing Plan')

@section('content')

<div class="page-content-wrapper py-3">           
    <div class="container">
        @foreach($dataPlans as $network)
        <div class="card mb-3">
            <div class="card-header" style="background-color: {{ $network['color'] }}">
                <h5 class="text-white">{{ ucfirst($network['networkName']) }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Amount</th>
                                <th>Validity</th>
                                <th>Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($network['plans'] as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $plan->amount }}</td>
                                <td>{{ $plan->validity }}</td>
                                <td>{{ $plan->selling_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</div>

@endsection
