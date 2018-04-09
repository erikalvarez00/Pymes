@extends('layouts.app')

@section('content')
    <div class="offset-md-2 col-md-8">
	    <form method="POST" action="{{ route('questions.store') }}">
	    	{{ csrf_field() }}
	    	
			<div class="card border-info">
				<div class="card-header bg-info text-white"><b>Insertar pregunta</b></div>
				<div class="card-body col-md-10 offset-md-1">
					<div class="row form-group">
						<label>Pregunta</label>
					</div>

					<div class="row form-group">
						<input class="form-control" type="text" name="question" placeholder="Introduzca su pregunta aquí" required>
					</div>

					<div class="row form-group">
						<label>Tipo de pregunta</label>
					</div>

					<div class="row text-center form-group">
					    <label class="col-md-3 radio-inline"><input type="radio" name="typeQuestion" value="2" checked>Abierta</label>
					    <label class="col-md-4 radio-inline"><input type="radio" name="typeQuestion" value="1">Cerrada simple</label>
				        <label class="col-md-5 radio-inline"><input type="radio" name="typeQuestion" value="3">Cerrada de opción múltiple</label>
					</div>

					<div class="row form-group" id="closedAnswersL" style="display: none;">
						<div class="row form-group w-100" id="r_0">
							<div class="col-md-8">
								<input type="text" class="form-control" name="opciones[]" placeholder="Inciso A">
							</div>
							<div class="col-md-4">
								<input type="button" class="btn btn-danger btn-block" name="borrar[]" value="Eliminar">
							</div>
						</div>

						<div class="row form-group w-100" id="r_1">
							<div class="col-md-8">
								<input type="text" class="form-control" name="opciones[]" placeholder="Inciso B">
							</div>
							<div class="col-md-4">
								<input type="button" class="btn btn-danger btn-block" name="borrar[]" value="Eliminar">
							</div>
						</div>
					</div>

					<div class="row form-group" id="closedAnswersB" style="display: none;">
						<input type="button" class="btn btn-secondary mx-auto" id="addClause" value="Agregar"></input>
					</div>

					<div class="row form-group">
						<div class="col-md-10">
							<label for="id_category">Categoría</label>
							<select class="form-control" name="id_category">
								<?php $aux = ""; ?>
								@foreach($categories as $category)
								    @if($aux !== $category -> area)
								        @if($aux !== "")
								            </optgroup>
								        @endif
								        <optgroup label="{{ $category -> area }}">
								            <?php $aux = $category -> area; ?>
								    @endif
								    <option value={{ $category -> id_category }}>
								    	{{ $category -> category }}
								    </option>
								@endforeach
							</select>
						</div>
					    <div class="col-md-2 text-center mt-auto mb-auto">
					        <label class="checkbox-inline"><input type="checkbox" name="status" value="1" checked> Activa</label>
					    </div>
				    </div>

					<div class="row form-group">
						<input type="submit" class="btn btn-info btn-block mx-auto" value="Guardar">
					</div>

					<div class="row form-group">
						<a class="btn btn-info btn-block mx-auto"  href="{{ route('questions.index') }}">Cancelar</a>
					</div>
				</div>
			</div>
	    </form>
	 </div>
@stop