@extends('layouts.header')
@section('title', 'Kyc List - Admin')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Kyc Submit</h1>
	</header>
	<div class="card">
		<div class="card-body">
		<div class="table-responsive search_result">
				@if($kyc->count())
				<table class="table" id="dows">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Date & Time</th>
							<th>User Name</th>
							<th>DOB</th>
							<th>Country</th>
							<th>Kyc Verify</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<tbody> 
					@foreach($kyc as $key => $user)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ date('m-d-Y H:i:s', strtotime($user->created_at)) }}</td>
							<td>{{ $user->fname }} {{ $user->lname }}</td>
							<td>{{ date('m-d-Y', strtotime($user->dob)) }}</td>
							<td>{{ $user->country }}</td>
							<td>@if($user->status == 2) Waiting @elseif($user->status == 1) Accepted @elseif($user->status == 3) Rejected @else No @endif</td>
							<td><a class="btn btn-success btn-xs" href="{{ url('admin/kycview/'.Crypt::encrypt($user->id)) }}"><i class="zmdi zmdi-edit"></i> View </a> </td>
						</tr> 
					@endforeach
					</tbody>
				</table>
				@else 
					{{ 'No record found! ' }}
				@endif
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="pagination-tt clearfix">
                    @if($kyc->count())
				    {{ $kyc->links() }}
				@endif
                </div>
              </div>
				
			</div>
		</div>
	</div>
</section>
@endsection


