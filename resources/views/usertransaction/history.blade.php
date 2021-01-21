@extends('layouts.header')
@section('title', 'User Deposit History - Admin')
@section('content')

<section class="content">
	<header class="content__title">
		<h1>User Transaction History</h1>
	</header>
  @include('layouts.message')
	<div class="card">
		<div class="card-body"> 
			<div class="row">
				<div class="col-md-3">                
					<input type="text" name="statdate" id="from_date" class="form-control date-picker" placeholder="From Date" />	
				</div>
				<div class="col-md-3">                
					<input type="text" id="to_date" name="st-date" class="form-control date-picker" placeholder="To Date" />
				</div>
				<div class="col-md-2">                
					<select class="form-control" id="pair">
						@foreach($pair as $pairs)
						<option value="{{$pairs->source}}">{{$pairs->source}}</option> 
						@endforeach
					</select>
				</div>
        <div class="col-md-2">                
          <select class="form-control" id="type"> 
            <option value="received">Deposit</option> 
            <option value="send">Withdraw</option>  
          </select>
        </div>
				<div class="col-md-2">                
					<select class="form-control" id="status">
						<option value="All">All</option>
						<option value="1">Pending</option>
						<option value="2">Approved</option> 
            <option value="3">Cancelled</option> 
					</select>
				</div>
			</div>
			<br/>
			<br/> 
		<div class="table-responsive search_result">
					<div id="history"></div>
                </div>
              </div>
				
			</div>
		</div>
	</div> 

  <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog"> 
          <form action="{{ url('admin/user_history_update') }}" method="post">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-body">
              <div class="col-md-12">Sender</div>
              <div class="col-md-12"><p id="sender"></p></div>
              <div class="col-md-12">Receiver</div>
              <div class="col-md-12"><p id="recipient"></p></div>
              <div class="col-md-12">Amount</div>
              <div class="col-md-12" id="amount">Amount Value</div>
              <p></p>
            </div>
            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="pair" id="edit_pair">
            <input type="hidden" name="status" id="edit_status">
            <input type="hidden" name="amount" id="amount">
            <input type="hidden" name="type_value" id="type_value">
            <div class="modal-footer">
            <input type="submit" class="btn btn-default" onclick="find_type(2)" value="Accept">
            <input type="submit" class="btn btn-danger" onclick="find_type(3)" value="Reject">
          </div>
        </div>
      </form>
      </div>
    </div>

</section>
<script type="text/javascript">
	$(document).ready(function() {
      	history_search()
	  });

	$('#from_date,#to_date,#pair,#status,#type').on('change', function(event){ 
	      history_search()
	  });

	function history_search(){
      $.ajax({
      url: '{{ url("/admin/user_history_search") }}',
      type: 'POST',
      data: {
        "_token": "{{ csrf_token() }}",
        "fromdate": $('#from_date').val(),
        "todate": $('#to_date').val(),
        "type": $('#type').val(),
        "pair": $('#pair').val(),
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
          "type": $('#type').val(),
          "pair": $('#pair').val(),
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
<script type="text/javascript">
  function status(id,pair,recipient,sender,amount,type)
  { 
    $('#edit_pair').val(pair);
    $('#edit_id').val(id);
    $('#recipient').html(recipient);
    $('#sender').html(sender);
    $('#amount').html(amount);
    $('#type_value').val(type);
    
  }

  function find_type(type)
  {
    $('#edit_status').val(type);
  }
</script>
@endsection