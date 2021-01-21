@extends('layouts.header')
@section('title', 'Support Ticket')
@section('content')
<section class="content">
<header class="content__title">
  <h1>Support</h1>
</header>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      @if($tickets->count() > 0)
      <table class="table">
        <thead>
          <tr>
            <th>Date & Time</th>
            <th>Ticket ID</th>
            <th>Username</th>
            <th>Subject</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickets as $ticket)
          <tr>
            <td>{{ date('d-m-Y H:i:s', strtotime($ticket->created_at)) }}</td>
            <td>{{ $ticket->reference_no }}</td>
            <td><a href="{{ url('admin/users_edit/'.Crypt::encrypt($ticket->user_id)) }} ">{{ username($ticket->user_id) }}</a></td> 
            <td>{{ $ticket->subject }}</td>
            <td><a class="btn btn-primary btn-xs"  href="{{ url('/admin/support/'.Crypt::encrypt($ticket->id)) }}" class="btn btn-info">Chat</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
          <div class="pagination-tt clearfix">
            @if($tickets->count())
              {{ $tickets->links() }}
            @endif
          </div>
        </div>
      @else 
      Yet no one raise support ticket
      @endif
    </div>
  </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> Delete </div>
      <div class="modal-body"> Are you sure you want to delete this user? </div>
      <div class="modal-footer"> <a class="btn btn-danger btn-ok">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
</div>
</section>
@endsection