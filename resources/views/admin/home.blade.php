@extends('admin.layout.app')
@section('pageTitle','Home')
@section('content')

<main id="main-container">
        
  <div class="content">
    <div class="row">
      
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-users fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">{{ $totalUsers }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Total Users</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-users fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">{{ $registeredToday }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Registered Today</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-wallet fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">&#x20A6;{{ @$totalWalletBalance }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Total Wallet Balance</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-money fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">&#x20A6;{{ @$todayTotalFunding }}</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Today's Total Funding</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
          <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
            <div class="d-none d-sm-block">
              <i class="fa fa-database fa-2x opacity-25"></i>
            </div>
            <div>
              <div class="fs-3 fw-semibold">{{ @$totalDataPurchaseInGB }} GB</div>
              <div class="fs-sm fw-semibold text-uppercase text-muted">Today's Data Purchase</div>
            </div>
          </div>
        </a>
      </div>


      <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
            <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                <div class="d-none d-sm-block">
                    <i class="fa fa-phone fa-2x opacity-25"></i>
                </div>
                <div>
                    <div class="fs-3 fw-semibold">&#x20A6;-</div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Today's Airtime Purchase</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-xl-3">
        <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
            <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                <div class="d-none d-sm-block">
                    <i class="fa fa-money fa-2x opacity-25"></i>
                </div>
                <div>
                    <div class="fs-3 fw-semibold">&#x20A6;{{ @$TotalFunding }}</div>
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Total Funding</div>
                </div>
            </div>
        </a>
    </div>


    <div class="row">
      <div class="col-md-6">
          <canvas id="dataPurchasesChart"></canvas>
      </div>
      <div class="col-md-6">
          <canvas id="fundingChart"></canvas>
      </div>
      <div class="col-md-6">
          <canvas id="registrationsChart"></canvas>
      </div>
  </div>

    
      
    </div>
   
  </div>
  
</main>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxFunding = document.getElementById('fundingChart').getContext('2d');
    var ctxRegistrations = document.getElementById('registrationsChart').getContext('2d');

    var ctxDataPurchases = document.getElementById('dataPurchasesChart').getContext('2d');

    var dataPurchasesChart = new Chart(ctxDataPurchases, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Data Purchases',
                data: @json($totalDataPurchaseInGB),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var fundingChart = new Chart(ctxFunding, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Total Funding',
                data: @json($funding),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var registrationsChart = new Chart(ctxRegistrations, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Registrations',
                data: @json($registrations),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
