@if (session('status'))
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">×</span>
    </button>
    <strong>{{ session('status') }}</strong>
</div>
@endif