@extends('layout.app')

@section('pageTitle', 'Transaction History')

@section('content')

<div class="page-content-wrapper py-3">           
    <div class="container">
        @if ($transactions->isEmpty())
            <p class="text-center">No recent transactions.</p>
        @else
            <ul class="ps-0 chat-user-list">
                @foreach ($transactions as $transaction)
                <!-- Single Transaction -->
                <li class="p-3">
                    <div class="chat-user-info">
                        <h6 class="text-truncate mb-0">{{ $transaction->created_at->format('M d, Y H:i') }}</h6>
                        <div class="last-chat">
                            @php
                            $plan = App\Models\DataPlan::where('plan_id', $transaction->data_plan_id)->first();
                        @endphp
                        
                        @if($plan)
                            <p class="mb-0 text-truncate">Amount: {{ $plan->amount }}</p>
                        @else
                            <p class="mb-0 text-truncate">Amount: Data Plan Deleted</p>
                        @endif
                        <p class="mb-0 text-truncate">Status: 
                            <span class="badge {{ $transaction->status === 'success' ? 'bg-success' : ($transaction->status === 'failed' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $transaction->status }}
                            </span>
                        </p>
                       </div>
                    </div>
                    <!-- Options -->
                    <div class="dropstart chat-options-btn">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="bi bi-clipboard"></i>Copy ID</a></li>
                        </ul>
                    </div>
                </li>
                <!-- End Single Transaction -->
                @endforeach
            </ul>
            
            <!-- Pagination -->
            {{-- {{ $transactions->links() }} --}}

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center direction-rtl  mt-2 pagination-one">
                    {{ $transactions->links() }}
                </ul>
            </nav>
            

              
        @endif
    </div>
</div>

@endsection
