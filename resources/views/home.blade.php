@extends('layouts.app')

@section('content')
	<div class="container card shadow-sm text-center">
		@guest
			<h2 class="display-4 align-middle">Inicie sesión para ingresar al sistema</h2>
		@else
			<ol>
				<a class="btn btn-lg btn-block btn-primary" type="button" href="{{ route('formCursos') }}">Crear un curso</a>
				<a class="btn btn-lg btn-block btn-primary" type="button" href="{{ route('cursos') }}">Cursos disponibles</a>
				<a class="btn btn-lg btn-block btn-primary" type="button" href="/api/user/{{Auth::user()->id}}">Consultar cursos a los que estoy inscripto</a>
			</ol>
		@endguest
	</div>
@endsection