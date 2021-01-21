@extends('layouts.header')
@section('title', 'Admin Bank')
@section('content')
<section class="content">
	<header class="content__title">
		<h1>Company Bank Details</h1>
	</header>
	<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
		   <div class="table-responsive search_result">
				<table class="table" id="dows">
					<thead>
						<tr>
							<th>Date & Time</th>
							<th>Coin Name</th>
							<th>Bank Details</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					    @if(count($bank) > 0)
							@foreach($bank as $admin_banks)
						 @php $account = strlen($admin_banks->account) > 50 ? substr($admin_banks->account,0,50)."..." : $admin_banks->account;
						 @endphp
						<tr>
							<td>{{ date('Y/m/d h:i:s', strtotime($admin_banks->created_at)) }}</td>
							<td>{{ $admin_banks->coin }}</td>
							<td>{{ $account }}</td>
							<td><a class="btn btn-success btn-xs" href="{{ url('/admin/edit_bank/'.Crypt::encrypt($admin_banks->id)) }}"><i class="zmdi zmdi-edit"></i> Update </a> </td>
						</tr>
					@endforeach
					@else
					    <tr><td colspan="7"> No record found!</td></tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>
	</div>
</section>
@endsection