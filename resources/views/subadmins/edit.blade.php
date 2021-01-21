@extends('layouts.header')
@section('title', 'Sub Admin Edit')
@section('content')
<section class="content">
	<header class="content__title"><h1>Sub Admin Edit</h1></header>
  	@include('layouts.message')  
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<a href="{{ route('subadmins.index') }}"><i class="zmdi zmdi-arrow-left"></i>Back to Sub Admin</a>
					<br /><br />
			      	<form method="post" action="{{ route('subadmins.update') }}" autocomplete="off">
			      		{{ csrf_field() }}
				      	<input type="hidden" name="user_id" value="{{$subadmin->id}}">
				        <div class="row form-group">
					        <label class="col-md-3">Email</label>
				          	<div class="col-md-4">
				              	<input type="email" name="email" placeholder="Enter Email" class="form-control" value="{{$subadmin->email}}" readonly="">
				            </div> 
				        </div>
						<?php $role_array = explode(",",$subadmin->role);?> 
				        <div class="row form-group">
							<label class="col-md-3">Access Lists</label>
							<div class="col-md-9">
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_all" name="access[]" value="all" 
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("all"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>>
									<label for="select_permission_all" >All</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_user" name="access[]" value="user" 
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("user"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>
									>
									<label for="select_permission_user">User</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_kyc" name="access[]" value="kyc" 
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("kyc"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>
  									>
									<label for="select_permission_kyc">Kyc</label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_commission" name="access[]" value="commission" 
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("commission"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>>
									<label for="select_permission_commission">Commission</label><br>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_sitesettings" name="access[]" value="sitesetting" 
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("sitesetting"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>>
									<label for="select_permission_sitesettings">Site Settings</label><br>
								</div>
								<div class="col-md-2">
									<input type="checkbox" id="select_permission_support" name="access[]" value="support"
									<?php 
										$role_count=count($role_array);                
  										for($i=0;$i<$role_count;$i++){  
  											if("support"==$role_array[$i]){ 
  												echo "checked"; 
  											}
  										} 
  									?>>
									<label for="select_permission_support">Support</label><br>
								</div>
							</div>
						</div>
				        <div class="form-group">
				          	<button type="submit" class="btn btn-light">Save</button>
				        </div>
				    </form>
				    <hr />
				    <form method="post" action="{{ route('security_settings.change_password') }}" autocomplete="off">
				      	{{ csrf_field() }}
				      	<input type="hidden" name="user_id" value="{{$subadmin->id}}">
				        <div class="row form-group">
					        <label class="col-md-3">Current Password</label>
				          	<div class="col-md-4">
				              	<input type="password" name="oldpassword"  placeholder="Old Password" id="site_title" class="form-control" value="">
				              	<strong class="text-danger">{{ $errors->first('oldpassword') }}</strong>
				              	<i class="form-group__bar"></i> 
				          	</div> 
				        </div>
				        <div class="row form-group">
					        <label class="col-md-3">New Password</label>
				          	<div class="col-md-4">
					            <input type="password" name="newpassword"  placeholder="New Password" class="form-control" value="">
					              <strong class="text-danger">{{ $errors->first('newpassword') }}</strong>
					              <i class="form-group__bar"></i> 
					        </div> 
				        </div>
				        <div class="row form-group">
					        <label class="col-md-3">Confirm New Password</label>
				          	<div class="col-md-4">
				              	<input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" value="" >
				              	<strong class="text-danger">{{ $errors->first('confirmpassword') }}</strong>
				              	<i class="form-group__bar"></i> 
				            </div> 
				        </div>
				        <div class="form-group">
				          	<button type="submit" name="change_password" class="btn btn-light"><i class=""></i> Change Password</button>
				        </div>
				    </form>
				</div>
			</div>
		</div>
	</div>
@endsection