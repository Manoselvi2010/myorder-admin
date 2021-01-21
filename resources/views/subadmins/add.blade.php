@extends('layouts.header')
@section('title', 'Sub Admin Add')
@section('content')
<section class="content">
	<header class="content__title"><h1>Sub Admin</h1></header>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('subadmins.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Subadmin</a>
					<br /><br />
					<form method="POST" action="{{ route('subadmins.store') }}">
						{{ csrf_field() }}
						<div class="row form-group">
							<label class="col-md-3">Email</label>
							<div class="col-md-4">
								<input type="email" name="email" class="form-control" required="">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-3">Password</label>
							<div class="col-md-4">
								<input type="password" name="password" class="form-control" required="">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-md-3">Access Lists</label>
							<div class="col-md-9">
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_all" name="access[]" value="all">
									<label for="select_permission_all">All</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_user" name="access[]" value="user">
									<label for="select_permission_user">User</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_kyc" name="access[]" value="kyc">
									<label for="select_permission_kyc">Kyc</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_commission" name="access[]" value="commission">
									<label for="select_permission_commission">Commission</label><br>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_sitesettings" name="access[]" value="sitesetting">
									<label for="select_permission_sitesettings">Site Settings</label><br>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_support" name="access[]" value="support">
									<label for="select_permission_support">Support</label><br>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" name="edit" class="btn btn-light"><i class=""></i> Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
		  	enable_cb();
		  	$("#select_permission_all").click(enable_cb);
		});
		function enable_cb() {
		  	if (this.checked) 
		  	{
			  	$("#select_permission_support").attr("disabled", true);
			    $("#select_permission_user").attr("disabled", true);
			    $("#select_permission_kyc").attr("disabled", true);
			    $("#select_permission_commission").attr("disabled", true);
			    $("#select_permission_sitesettings").attr("disabled", true);
		  	} else {
			    $("#select_permission_support").removeAttr("disabled");
			    $("#select_permission_user").removeAttr("disabled");
			    $("#select_permission_kyc").removeAttr("disabled");
			    $("#select_permission_commission").removeAttr("disabled");
			    $("#select_permission_sitesettings").removeAttr("disabled");
		  	}
		}
	</script>
@endsection