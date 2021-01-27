@extends('layouts.header')
@section('title', 'Users List - Admin')
@section('content')
<?php $user_url = config('app.user_url'); ?>
<section class="content">
	<header class="content__title">
		<h1>Send a mail to User</h1>
	</header>
	<a href="{{ route('users.index') }}"><i class="zmdi zmdi-arrow-left"></i> Back to Users</a>
	<br /><br />
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="tab-container">
						<form method="post" action="{{route('mails.single_mail_submit')}}">
        					{{ csrf_field() }}		                    
		                    <input type="hidden" name="user_id" value="{{$user->id}}">
		                    <div class="row form-group">                        
		                        <label class="col-sm-2 col-lg-2 col-form-label">User Name<span class="req">*</span></label>
		                        <div class="col-sm-8 col-lg-7">
		                           <input type="text" name="name" class="form-control" placeholder="Name" required="" value="{{$user->fname}} {{$user->fname}}" readonly="">
		                        </div>
		                    </div>
		                    <div class="row form-group">                        
		                        <label class="col-sm-2 col-lg-2 col-form-label">Subject<span class="req">*</span></label>
		                        <div class="col-sm-7 col-lg-7">
		                            <input type="text" name="subject" class="form-control" placeholder="Subject" required="">
		                        </div>
		                    </div>
		                    <div class="row form-group">
		                        <label class="col-sm-2 col-lg-2 col-form-label">Content<span class="req">*</span></label>
		                        <div class="col-sm-7 col-lg-7">
		                            <div class="input-group">
		                                <textarea class="form-control" id="content" name="content" placeholder="Content" rows="4"></textarea>
		                            </div>
		                        </div>
		                    </div>                   
		                    <div class="row">
		                        <div class="col-md-12 text-center">
		                            <input type="submit" class="btn btn-success" value="Send SMS">
		                            <a href="{{route('users.index')}}" class="btn btn-secondary ml-10">Cancel</a>
		                        </div>
		                    </div>
		                </form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection