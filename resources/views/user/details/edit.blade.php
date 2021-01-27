@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<?php $user_url = config('app.user_url'); ?>
<section class="content">
	<header class="content__title">
		<h1>View User Details</h1>
	</header>
	<a href="{{ url('admin/users/') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Users</a>
	<br /><br />
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="tab-container">
						@if(session('updated_status'))
							<div class="alert alert-success">
								{{ session('updated_status') }}
							</div>
						@endif
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#wallet" role="tab">Wallet</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#transaction" role="tab">Transaction</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#buy-trade" role="tab">Buy Trade</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#sell-trade" role="tab">Sell Trade</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tickets" role="tab">Tickets</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active fade show" id="profile" role="tabpanel">
								@include('user.details.profile')
							</div>
							<div class="tab-pane fade" id="wallet" role="tabpanel">
								@include('user.details.wallet')
							</div>
							<div class="tab-pane fade" id="transaction" role="tabpanel">
								@include('user.transactions.deposit_history')
							</div>
							<div class="tab-pane fade" id="buy-trade" role="tabpanel">
								@include('user.tradehistory.tradehistroy-buy')					
							</div>
							<div class="tab-pane fade" id="sell-trade" role="tabpanel">
								@include('user.tradehistory.tradehistroy-sell')				
							</div>							
							<div class="tab-pane fade" id="tickets" role="tabpanel">
								@include('user.details.tickets')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection