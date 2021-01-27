<form method="post" action="{{ url('admin/update_user') }}" autocomplete="off">
	{{ csrf_field() }}
	<input type="hidden" value="{{ $userdetails->id }}" name="id">
	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Full Name</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<input type="text" name="fname" class="form-control" value="{{ $userdetails->fname != NULL ? $userdetails->fname : '' }}"/><i class="form-group__bar"></i>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Email ID</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<input type="email" name="email" class="form-control" value="{{ $userdetails->email }}" /><i class="form-group__bar"></i>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Country</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<select class="form-control" name="country">
						@if($userdetails->country == '')
							<option value="">County not Update</option> 
							@foreach(country() as $countrys)
							<option value="{{ $countrys->id }}" @if($countrys->id == $userdetails->country ) {{ selected }} @else {{ '' }}>{{ $countrys->name }}@endif</option> 
							@endforeach
						@else 
							@foreach(country() as $countrys)
								<option value="{{ $countrys->id }}" @if($countrys->id == $userdetails->country ) {{ "selected" }} @else {{ '' }}@endif>{{country_name($countrys->id)->name
								}}</option> 
							@endforeach
						@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Phone No</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<input type="text" name="phone" class="form-control" value="" /><i class="form-group__bar"></i>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Email Verified</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<div class="form-group">
							<input type="text" name="emailcheck" class="form-control" value="{{ $userdetails->email_verify == 1 ? 'Verified' : 'Not Verified' }}" disabled/><i class="form-group__bar"></i>
						</div>										
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>2FA (you have only disable rights)</label>
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
					    <div class="form-group">
					       <input name="twofactor" value="enable" type="radio" @if($userdetails->google2fa_secret != NULL || $userdetails->email2fa_otp == 1) checked @endif disabled> YES
					       &nbsp;&nbsp;&nbsp;<input name="twofactor" value="disable" type="radio" @if($userdetails->google2fa_secret == NULL && $userdetails->email2fa_otp == 0) checked @endif >NO
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-3">2FA google2fa secret code</label>
				<div class="col-md-9">
				    @if($userdetails->google2fa_secret != NULL ) 
				    	{{$userdetails->google2fa_secret}}
				    @else
				    	-
				    @endif
				</div>
			</div>
		</div>
		<div class="col-md-4">
			@if($userdetails->image == null)
                <img src="{{ $user_url.'/storage/app/public/profile/no-image.jpeg' }}"  style= "width:200px;height: auto;"/>
            @else
                <img src="{{ $user_url.'/'.$userdetails->image }}" style= "width:200px;height: auto;" />
            @endif
		</div>
	</div>
	<!-- 	<div class="form-group">
		<button type="submit" name="edit" class="btn btn-light"><i class=""></i> Update</button>
	</div> -->
</form>		