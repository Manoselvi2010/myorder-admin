@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<section class="content">
	<header class="content__title"><h1>Users</h1></header>
  	@include('errors.success')  
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
						<a class="btn btn-warning btn-xs" href="{{ url('/admin/users') }}"> Reset </a> 
					</div>
				</div>
			</form>
			<br/>
			<div id="sellstatus" class="alert alert-success" style="display: none;"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 userexprotlet">
				@if(session('updated_status'))
				    <div class="alert alert-success">{{ session('updated_status') }}</div>
				@endif
				@if($details)
	    			<h5> Total Users : {{ count($details) }} </h5>
	    			<hr />
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
							<th>Date</th>
							<th>Full Name</th>
							<th>Email ID</th>
							<th>Email Verify</th>
							<th>Kyc</th>
							<th>IP Address</th>
							<th>User Status</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<tbody>
					 	@if(count($details) > 0)
							@foreach($details as $key => $user)
								<tr>
									<td>{{ $key+1 }}</td>
                                    <td>{{ date('m-d-Y ', strtotime($user->created_at)) }}</td>
									<td>
										@if($user->login_status == 1)
											<i class="fa fa-circle text-success" style="font-size: 10px"></i>
										@else
											<i class="fa fa-circle" style="font-size: 10px;color: gray"></i>							
										@endif
										{{ $user->fname }} {{ $user->lname }}</td>
									<td>{{ $user->email }}</td>
									<td>
										@if($user->email_verify == 1) Yes @elseif($user->email_verify == 2) Waiting @else No @endif
									</td>
									<td>
										@if($user->kyc_verify == 1) 
											<a href="{{ url('admin/kycview/'.Crypt::encrypt($user->kyc_id)) }}">Verified</a>
										@elseif($user->kyc_verify == 2)
										 	<a href="{{ url('admin/kycview/'.Crypt::encrypt($user->kyc_id)) }}">Waiting</a>
										@elseif($user->kyc_verify == 3)
											<a href="{{ url('admin/kycview/'.Crypt::encrypt($user->kyc_id)) }}">Rejected</a>
										@else 
										 	Not Applied 
										@endif
									</td>									
									<td>
										@if($user->ipaddress != null)
											{{$user->ipaddress}}
										@else
											-
										@endif
									</td>
									<td id="{{ $user->id }}">
										@if($user->status == 1)
											<button class="btn btn-danger btn-xs" onclick="changestatus(2,{{ $user->id }})">Deactivate</button>
										@else
											<button class="btn btn-danger btn-xs" onclick="changestatus(1,{{ $user->id }})">Activate</button>
										@endif
									</td>
									<td>
										<a class="btn btn-success btn-xs" href="{{ route('users.edit',Crypt::encrypt($user->id)) }}"><i class="zmdi zmdi-edit"></i> View </a>
										<a href="{{route('mails.show',$user->id)}}" class="btn btn-icon btn-warning" style="color: #fff">
                                            <i class="zmdi zmdi-email"></i>
                                        </a>
									</td>
									<td>
										<a class="btn btn-success btn-xs" href="{{ route('excel.show',Crypt::encrypt($user->id)) }}"><i class="zmdi zmdi-download zmdi-hc-fw"></i> Export </a>
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
