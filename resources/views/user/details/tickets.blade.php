<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 site-size">
	  	<div class="banner-border">
		    <div class="panel panel-content panel-default panel-border">
		      	<div class="panel-body pt-0">
			        <div class="testDiv4">
			          <div class="table-responsive table" id="trade_history_buy">
			          	<div class="table-responsive search_result">
						  <table class="table" style="background-color: #1a417d;">
						    <thead>
						      <tr>
						        <th>Sno</th>
						        <th>Date & Time</th>
						        <th>Subject</th>
						        <!-- <th>Status</th> -->
						        <th>Action</th>
						      </tr>
						    </thead>
						    <tbody class="site-table">
						      	@forelse($tickets as $key => $ticket)
							      	<tr>
			                  			<td>{{ $key+1 }}</td>
								        <td>{{$ticket->created_at}}</td>
								        <td>{{$ticket->subject}}</td>
								      <!--  	<td>
								          	@if($ticket->status==0)
								          		Unread					          	
								          	@else
								          		Read
								          	@endif
								        </td> -->
								        <td><a class="btn btn-primary btn-xs"  href="{{ url('/admin/support/'.Crypt::encrypt($ticket->id)) }}" class="btn btn-info">Chat</a></td>
							      	</tr>
						      	@empty
							      	<tr>
							        	<td colspan="8" > No Records Found </td>
							      	</tr> 
						      	@endforelse
						    </tbody>
						  </table>
						</div>
			          </div>
			        </div>                   
		      	</div>
		    </div>
	  	</div>
	</div>
</div>
       