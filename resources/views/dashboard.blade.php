@extends('layouts.header')
@section('title', 'Admin Dashboard')
@section('content') 
<section class="content">
    <header class="content__title"><h1>Dashboard</h1></header>
    <div class="row quick-stats listview2">
        <div class="col-sm-6 col-md-3">
            <!-- <a href="{{ url('admin/today_users') }}"> -->
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['todayusers'] }}</h2>
                    <small>New Users</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-user"></i></h1>
                </div>
            </div>
            <!-- </a> -->
        </div>            
        <div class="col-sm-6 col-md-3">
            <!-- <a href="{{ url('admin/users') }}"> -->
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">                       
                    <h2>{{ $details['totalusers'] }}</h2>
                    <small>Total Users</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-users" aria-hidden="true"></i></h1>
                </div>
            </div>
            <!-- </a> -->
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['today_transactions'] }}</h2>
                    <small>Today Transaction</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-calendar-o"></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['total_transactions'] }}</h2>
                    <small>Total Transaction</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-list-alt"></i></h1>
                </div>
            </div>
        </div>
    </div>
	<div class="row quick-stats listview2">
        <div class="col-sm-6 col-md-3">
            <!-- <a href="{{ url('admin/kyc_request_users') }}"> -->
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['email_unverified_users'] }} (EMAIL)</h2>
                    <small>Unverified Users</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-id-card-o"></i></h1>
                </div>
            </div>
            <!-- </a> -->
        </div>
        <div class="col-sm-6 col-md-3">
            <!-- <a href="{{ url('admin/deactive_users') }}"> -->
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2></h2>
                    <small>Deactivate Users</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-user-times" aria-hidden="true"></i></h1>
                </div>
            </div>
            <!-- </a> -->
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['total_deposit'] }}</h2>
                    <small>Deposit Request</small> 
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-money"></i></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item">
                <div class="quick-stats__info col-md-8">
                    <h2>{{ $details['total_withdraw'] }}</h2>
                    <small>Withdraw Request</small>
                </div>
                <div class="col-md-4 text-right">
                    <h1><i class="fa fa-hand-lizard-o"></i></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Support Ticket</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>User Name</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td>{{ date('m-d-Y ', strtotime($ticket->created_at)) }}</td>
                                        <td>{{ username($ticket->user_id) }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td><a class="btn btn-success btn-xs" href="{{ url('/admin/support/'.Crypt::encrypt($ticket->id)) }}"><i class="zmdi zmdi-edit"></i> </a> </td>
                                    </tr>
                                @empty
                                <tr><td colspan="6"> No Record Found!</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent KYC Submit Users (Pending)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Username</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kyc_details as $kyc_detail)
                                    <tr>
                                        <td>{{ date('m-d-Y', strtotime($kyc_detail->created_at)) }}</td>
                                        <td>{{ username($kyc_detail->user_id) }}</td>
                                        <td>{{ $kyc_detail->country }}</td>
                                        <td>Awaiting Confirmation </td>
                                        <td><a class="btn btn-success btn-xs" href="{{ url('admin/kycview/'.Crypt::encrypt($kyc_detail->kyc_id)) }}"><i class="zmdi zmdi-edit"></i></a> </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"> No Record Found!</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="content__title"><h1>Admin Earning Details</h1></header>
    <div class="row quick-stats listview2">
        @foreach($commissions as $commission)
            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>{{ $commission->source }}</h2>
                                <small>
                                    <?php $admin_earning = $commission->trade_commission + $commission->withdraw_commission ?>
                                    <!-- {{ number_format($admin_earning,8,'.','')}} -->
                                    Trade: {{ number_format($commission->trade_commission,8,'.','')}}
                                </small> 
                                <small>
                                    Withdraw: {{ number_format($commission->withdraw_commission,8,'.','')}}
                                </small> 
                            </div>
                            <div class="col-md-4">
                                <img src="{{ url('images/'.$commission->source.'.png') }}" style="width: 100%">
                            </div>
                        </div>
                    </div>                  
                </div>  
            </div>   
        @endforeach
    </div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
                <div class="card-body">
                    <h4 class="card-title">Market cap</h4>
                    <div class="flot-chart flot-pie"></div>
                    <div class="flot-chart-legends flot-chart-legend--pie"></div>
                </div>
            </div>
		</div>
		<div class="col-md-6">
			<div class="card">
                <div class="card-body">
                    <h4 class="card-title">Admin Earnings</h4>
                    <div class="flot-chart flot-bar"></div>
                    <div class="flot-chart-legends flot-chart-legends--bar"></div>
                </div>
            </div>
		</div>
	</div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title"><i class="fa fa-map-marker" style="font-size: 20px"></i> Visitors</h4>
                </div>
                <div id="regions_div" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</section>
<!-- Investments Pie Chart  -->
<script type="text/javascript">
    'use strict';
    $(document).ready(function(){
        // color changing dynamicallly function
        function dynamicColor() {
                var r = Math.floor(Math.random() * 200);
                var g = Math.floor(Math.random() * 200);
                var b = Math.floor(Math.random() * 200);
                var dynamic_color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
        };
        var pieData = [
                        <?php 
                            if(isset($user_wallets)){
                                foreach ($user_wallets as $key => $user_wallet) { 
                                    $dynamic_color = "dynamicColor()";
                        ?>
                            {data: "{{$user_wallet->total_balance}}", color: {{$dynamic_color}}, label: '{{$user_wallet->total_balance}}   {{$user_wallet->source}}'},
                            // {data: "{{$siteUserBalance['ETH']}}", color: dynamic_color, label: '{{$siteUserBalance["ETH"]}} ETH'},
                        <?php } } ?>
                    ];
        // Pie Chart
        if($('.flot-pie')[0]){
            $.plot('.flot-pie', pieData, {
                series: {
                    pie: {
                        show: true,
                        stroke: {
                            width: 0
                        }
                    }
                },
                legend: {
                    container: '.flot-chart-legend--pie',
                    noColumns: 0,
                    lineWidth: 0,
                    labelBoxBorderColor: 'rgba(255,255,255,0)'
                }
            });
        }
        // Donut Chart
        // if($('.flot-donut')[0]){
        //     $.plot('.flot-donut', pieData, {
        //         series: {
        //             pie: {
        //                 innerRadius: 0.5,
        //                 show: true,
        //                 stroke: { 
        //                     width: 0
        //                 }
        //             }
        //         },
        //         legend: {
        //             container: '.flot-chart-legend--donut',
        //             noColumns: 0,
        //             lineWidth: 0,
        //             labelBoxBorderColor: 'rgba(255,255,255,0)'
        //         }
        //     });
        // }
    });
</script>
<!-- Admin Earnings Chart -->
<script type="text/javascript">
    'use strict';
    $(document).ready(function(){
        function dynamicColor() {
            var randomColor = Math.floor(Math.random()*16777215).toString(16);
            var dynamic_color = "#" + randomColor;
            console.log(dynamic_color);
        };
        // Chart Data
        var barChartData = [
                                <?php 
                                    if(isset($commissions))
                                    {
                                        foreach ($commissions as $key => $commission) 
                                        { 
                                            $admin_earning = $commission->trade_commission + $commission->withdraw_commission;
                                            $dynamic_color = "dynamicColor()";
                                ?>
                                {
                                    label: '{{ $commission->source }}',
                                    data: [[1,"{{ $admin_earning}}"]],
                                    bars: {
                                        order: {{$key}},
                                        fillColor: {{$dynamic_color}}
                                    },
                                    color: {{$dynamic_color}}                                    
                                },                               
                                <?php } } ?>
                            ];
        // Chart Options
        var barChartOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.075,
                    fill: 1,
                    lineWidth: 0
                }
            },
            grid : {
                borderWidth: 1,
                borderColor: 'rgba(255,255,255,0.1)',
                show : true,
                hoverable : true,
                clickable : true
            },
            yaxis: {
                tickColor: 'rgba(255,255,255,0.1)',
                tickDecimals: 0,
                font: {
                    lineHeight: 13,
                    style: 'normal',
                    color: 'rgba(255,255,255,0.75)',
                    size: 11
                },
                shadowSize: 0
            },
            xaxis: {
                tickColor: 'rgba(255,255,255,0.1)',
                tickDecimals: 0,
                font: {
                    lineHeight: 13,
                    style: 'normal',
                    color: 'rgba(255,255,255,0.75)',
                    size: 11
                },
                shadowSize: 0
            },
            legend:{
                container: '.flot-chart-legends--bar',
                backgroundOpacity: 0.5,
                noColumns: 0,
                lineWidth: 0,
                labelBoxBorderColor: 'rgba(255,255,255,0)'
            }
        };
        // Create chart
        if ($('.flot-bar')[0]) {
            $.plot($('.flot-bar'), barChartData, barChartOptions);
        }
    });
</script>
<!-- number of visitors google map -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
                                    'packages':['geochart'],
                                    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                                    'mapsApiKey': 'AIzaSyAOFxgkRhB6WKRISnaCfdD3Gb0BufAVUAc'
                                });
    google.charts.setOnLoadCallback(drawRegionsMap);
    function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
                                                            ['Country', 'Users'],
                                                            <?php 
                                                                if(isset($user_countries)){
                                                                    foreach ($user_countries as $key => $user_country) { ?>
                                                                    ['{{$user_country->country_code}}', {{$user_country->count}} ],
                                                            <?php } }?>
                                                        ]);
        var options = {
                        colors: ['green', 'orange', 'yellow']
                    };
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
    }
</script>
@endsection