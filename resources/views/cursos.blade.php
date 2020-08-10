@extends('layouts.app')

@section('content')

	<table class="table">
		<thead class="thead-default">
		    <tr class="row">
		        <th class="col"><strong> Curso </strong></th>
		        <th class="col"><strong> Cupo </strong></th>
		        <th class="col"><strong> Docente </strong></th>
		        <th class="col"><strong> Opciones </strong></th>
		    </tr>
		</thead>
		<tbody>
		    @foreach($cursos as $objCurso)
					<tr class="row">
						<td class="col">{{ $objCurso->curso }}</td>
						<td class="col">{{ $objCurso->cupo }}</td>
						<td class="col">{{ $objCurso->docente }}</td>
						<td class="col">
							<div class="">
								<a class="btn btn-primary" role="button" href="{{ route('cursos.inscribir', $objCurso) }}">Inscribirse</a>

								<a class="btn btn-info" role="button" href="{{ route('cursos.editar', $objCurso) }}">Editar</a>
								<form class="btn" style="position: relative;" action="{{ route('cursos.eliminar', $objCurso) }}" method='POST'>
									@csrf @method('DELETE')
									<button type="submit" class="btn btn-danger" role="button">Eliminar</button>
								</form>
							</div>
						</td>
					</tr>
			@endforeach
	    </tbody>
	</table>
@endsection