@if (session('success'))
<div class="box-body">
	<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 2px">
           <span aria-hidden="true">×</span>
        </button>
        <strong>{{ session('success') }}</strong>
    </div>
</div>
@endif
