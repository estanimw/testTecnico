@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>
					<div class="card-body">
						<form id="cursos" action="{{ route('formCursosPost') }}" method="post" >
							@csrf
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-md-right">Nombre del curso:</label>
								<div class="col-md-6">
									<input class="form-control" type="text" name="curso" placeholder="Matemática I">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-md-right">Cupo</label>
								<div class="col-md-6">
									<input class="form-control" type="number" name="cupo" placeholder="15">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-md-right">Docente a cargo</label>
								<div class="col-md-6">
									<input class="form-control" type="text" name="docente" placeholder="Juan Perez">
								</div>
							</div>
							<div class="form-group row mb-0">
	                            <div class="col-md-6 offset-md-4">
	                                <button type="submit" class="btn btn-primary">
	                                    {{ __('Cargar curso') }}
	                                </button>
	                                <a class="btn btn-danger" href="{{ route('home') }}">Cancelar</a>
	                            </div>
                        	</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection