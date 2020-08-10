@if (session('status-ok'))
	<div class="alert alert-success text-center" role="alert">
		{{ session('status-ok') }}
	</div>
@elseif (Session::has('status-warning'))
	<div class="alert alert-warning text-center" role="alert">
		{{ Session::get('status-warning') }}
	</div>
@endif