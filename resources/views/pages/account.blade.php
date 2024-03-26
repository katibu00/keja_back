@extends('layout.app')
@section('pageTitle', 'Contact Us')
@section('content')
<div class="page-content-wrapper py-3">
    <div class="container">
      <!-- Setting Card-->
      <div class="card mb-3 shadow-sm">
        <div class="card-body direction-rtl">
          <p>Settings</p>
          <div class="single-setting-panel">
            <div class="form-check form-switch mb-2">
              <input class="form-check-input" type="checkbox" id="data-vendor-account" checked>
              <label class="form-check-label" for="data-vendor-account">Data Vendor Account</label>
            </div>
          </div>
          <div class="single-setting-panel">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="rtlSwitch">
              <label class="form-check-label" for="rtlSwitch">RTL Mode</label>
            </div>
          </div>

        </div>
      </div>
      <!-- Setting Card-->
      <div class="card mb-3 shadow-sm">
        <div class="card-body direction-rtl">
            <div class="chart-wrapper">
                <div id="lineChart2"></div>
              </div>
      </div>



     



      <!-- Setting Card-->
      <div class="card shadow-sm">
        <div class="card-body direction-rtl">
          <p>Account</p>
          <div class="single-setting-panel"><a href="#">
            <div class="icon-wrapper bg-info"><i class="bi bi-lock"></i></div>Change Password</a></div>
        <div class="single-setting-panel"><a href="{{ route('logout') }}">
              <div class="icon-wrapper bg-danger"><i class="bi bi-box-arrow-right"></i></div>Logout</a></div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
<script src="/frontend/js/apexcharts.min.js"></script>

<script>
    var lineChart2 = {
        chart: {
            height: 220,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },
        },
        colors: ['#2ecc4a'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        subtitle: {
            text: 'Last 15 days data purchases (GB)',
            align: 'left',
            margin: 0,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
                fontSize: '14px',
                color: '#8480ae',
            }
        },
        tooltip: {
            theme: 'dark',
            marker: {
                show: true,
            },
            x: {
                show: false,
            }
        },
        grid: {
            borderColor: '#dbeaea',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false,
                }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
        },
        series: [{
            name: "Data Purchases",
            data: @json($chartData)
        }],
        xaxis: {
    categories: @json(collect(range(14, 0))->map(function($i) {
        return \Carbon\Carbon::now()->subDays($i)->format('D');
    }))
}

    };

    var lineChart_2 = new ApexCharts(document.querySelector("#lineChart2"), lineChart2);
    lineChart_2.render();
</script>
</script>

@endsection
