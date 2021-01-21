@extends('layouts.header')
@section('title', ' Trade History')
@section('content')
<section class="content">
	<div class="card">
		<div class="card-body conts">
			<div class="row">
				<div class="col-md-12">
					<h5 class="text-uppercase maginf">Trade History</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="card"> 
		<div class="card-body">
			<div class="row">
				<div class="col-md-2">                
					<input type="text" name="statdate" id="from_date" class="form-control date-picker" placeholder="From Date" />	
				</div>
				<div class="col-md-2">                
					<input type="text" id="to_date" name="st-date" class="form-control date-picker" placeholder="To Date" />
				</div>
				<div class="col-md-2">                
					<input type="text" id="email" name="email" class="form-control" placeholder="Email" />
				</div>
				<div class="col-md-2">                
					<select class="form-control" id="tradepair"> 
						@foreach($pair as $pairs)
							<option value="{{ $pairs->id }}">{{$pairs->coinone}} / {{$pairs->cointwo}}</option> 
						@endforeach 
					</select>
				</div> 
				<div class="col-md-1">                
					<select class="form-control" id="type1"> 
						<option value="Buy">Buy</option>  
						<option value="Sell">Sell</option> 
					</select>
				</div> 
				<div class="col-md-1">                
					<select class="form-control" id="type2"> 
						<option value="1">Limit</option>  
						<option value="2">Market</option> 
					</select>
				</div>
				<div class="col-md-2">                
					<select class="form-control" id="status">
						<option value="All">All</option>
						<option value="0">Pending</option>
						<option value="1">Completed</option> 
						<option value="100">Cancelled</option> 
					</select>
				</div>
			</div>
			<br/>
			<br/> 
			<div class="tab-content">
				<div id="buyo" class="tab-pane fade in active show">
					<div id="history"></div>
				</div>
			</div>
		</div>
	</div>  
<script type="text/javascript">
	$(document).ready(function() {
      	history_search()
	  });

	$('#from_date,#to_date,#tradepair,#status,#type1,#type2,#email').on('change', function(event){ 
	      history_search()
	  });

	function history_search(){
      $.ajax({
      url: '{{ url("/admin/user_trade_search") }}',
      type: 'POST',
      data: {
        "_token": "{{ csrf_token() }}",
        "fromdate": $('#from_date').val(),
        "todate": $('#to_date').val(),
        "type1": $('#type1').val(),
        "type2": $('#type2').val(),
        "email": $('#email').val(),
        "tradepair": $('#tradepair').val(),
        "status": $('#status').val()
      }, 
      success: function (data) {
        $('#history').html(data); 
      },
    }); 
  };
</script>
<script type="text/javascript">

$(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        $('#load a').css('color', '#dfecf6');
        $('#load').append('loding');

        var url = $(this).attr('href');  
        getArticles(url);
        window.history.pushState("", "", url);
    });

    function getArticles(url) {
        $.ajax({
        url: url,
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          "fromdate": $('#from_date').val(),
          "todate": $('#to_date').val(),
          "type1": $('#type1').val(),
          "type2": $('#type2').val(),
          "email": $('#email').val(),
          "tradepair": $('#tradepair').val(),
          "status": $('#status').val(),
          "url": url
        }, 
        success: function (data) {
          $('#history').html(data); 
        },
      }); 
    }
});

</script>
@endsection