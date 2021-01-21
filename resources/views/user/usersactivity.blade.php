@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Users</h1>
	</header>
	<div class="card">
		<div class="card-body">
		    <form action="{{ url('/admin/users/search') }}" method="GET" autocomplete="off">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-3">                
						<input type="text" name="searchitem" class="form-control" placeholder="Search for User Name or Email" value= "" required>
					</div>
					<div class="col-md-3">
						<input type="submit" class="btn btn-success user_date" value="Search" />
						<a class="btn btn-warning btn-xs" href="{{ url('/admin/users_activity') }}"> Reset </a> 
					</div>
				</div>
			</form>
			<br/>
			<div id="sellstatus" class="alert alert-success" style="display: none;"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 userexprotlet">

			@if(session('updated_status'))
			    <div class="alert alert-success">
                    {{ session('updated_status') }}
                        </div>
			@endif

    	<!-- 	<div class="right-div exportright">
				<a href="{{url('admin/users/exportExcel')}}">
					<span class="btn btn-success user_date"> <i class="zmdi zmdi-download zmdi-hc-fw"></i> export</span>
				</a>
			</div> -->
		</div>
	

			<div class="table-responsive search_result">
				<table class="table" id="dows">
					<thead>
						<tr>
							<th>S No</th>
							<th>Full Name</th>
							<th>Email ID</th>
							<th>Process</th>
							<th>date and time</th>						
						</tr>
					</thead>
					<tbody>
					 @if(count($details) > 0)
					@foreach($details as $key => $user)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ username($user->user_id) }}</td>
							<td>{{ user($user->user_id)->email }}</td>
							<td>{{ $user->process }}</td>
							<td>{{ $user->created_at }}<td>
						</td>
						</tr>
					@endforeach
					@else
					    <tr><td colspan="7"> No record found!</td></tr>
					@endif
					</tbody>
				</table>
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="pagination-tt clearfix">
                @if($details->count())
				    {{ $details->links() }}
				@endif
                </div>
              </div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function changestatus(status,user)
	{
		$.ajax({
	      url: '{{ url("/admin/user_status") }}',
	      type: 'POST',
	      data: {
	        "_token": "{{ csrf_token() }}",
	        "status": status,
	        "user": user
	      }, 
	      success: function (data) {
	      	$('#sellstatus').html(data['message']);
	      	$("#sellstatus").attr("style", "display:block")
	        window.location.reload();
	      },
	    });
	}
</script>
@endsection


