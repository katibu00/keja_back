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
    </div>
    
    <!-- User Registrations Graph -->
    <div class="row">
      <div class="col-12">
        <div class="block block-rounded block-link-shadow">
          <div class="block-content">
            <h3 class="block-title">User Registrations (Last 15 Days)</h3>
            <canvas id="userRegistrationsChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Data Purchases Graph -->
    <div class="row">
      <div class="col-12">
        <div class="block block-rounded block-link-shadow">
          <div class="block-content">
            <h3 class="block-title">Data Purchases (Last 15 Days)</h3>
            <canvas id="dataPurchasesChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Funding Transactions Graph -->
    <div class="row">
      <div class="col-12">
        <div class="block block-rounded block-link-shadow">
          <div class="block-content">
            <h3 class="block-title">Funding Transactions (Last 15 Days)</h3>
            <canvas id="fundingTransactionsChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</main>

<!-- Include Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dates = @json($dates);
    const userRegistrations = @json($userRegistrations);
    const dataPurchasesInGB = @json($dataPurchasesInGB);
    const fundingTransactions = @json($fundingTransactions);

    // User Registrations Chart
    new Chart(document.getElementById('userRegistrationsChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
          label: 'User Registrations',
          data: userRegistrations,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          fill: true,
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Date'
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Registrations'
            }
          }
        }
      }
    });

    // Data Purchases Chart
    new Chart(document.getElementById('dataPurchasesChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
          label: 'Data Purchases (GB)',
          data: dataPurchasesInGB,
          borderColor: 'rgba(153, 102, 255, 1)',
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          fill: true,
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Date'
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Data Purchases (GB)'
            }
          }
        }
      }
    });

    // Funding Transactions Chart
    new Chart(document.getElementById('fundingTransactionsChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
          label: 'Funding Transactions (₦)',
          data: fundingTransactions,
          borderColor: 'rgba(255, 159, 64, 1)',
          backgroundColor: 'rgba(255, 159, 64, 0.2)',
          fill: true,
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            display: true,
            title: {
              display: true,
              text: 'Date'
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Funding Transactions (₦)'
            }
          }
        }
      }
    });
  });
</script>

@endsection
