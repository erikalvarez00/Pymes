@extends('layouts.app')

@section('content')
    <div class="offset-lg-2 col-lg-8">
    	<table class="table table-striped table-responsive" id="tbQuestionsList">
    		<thead class="stripe">
    			<tr>
    				<th>Pregunta</th>
    				<th>Area</th> 
    				<th>Categoria</th>
    				<th>Tipo</th>
    				<th>Estado</th>
    				<th></th>
    				<th></th>
    			</tr>
    		</thead>
    		@foreach($questions as $question)
    		    <tr>
    		    	<td>{{$question -> question}}</td>
    		    	<td>{{$question -> area}}</td>
    		    	<td>{{$question -> category}}</td>
    		    	<td>
    		    		{{
    		    			$question -> type === 'Open' ? 'Pregunta Abierta' : 
    		    			($question -> type === 'Binary' ? 'Pregunta Binaria' : 'Pregunta de opción múltiple')
    		    		}}
    		    	</td>
    		    	<td>{{$question -> status === 1 ? 'Activo':'Inactivo'}}</td>
    		    	<td>
    		    		<a href="{{ route('questions.edit', $question -> id_question) }}" class="btn btn-success" >Editar</a>
    		    	</td>
    		    	<td>
    		    		<form  class="d-inline" name="deleteQuestion[]" method="POST" action="{{ route('questions.destroy', $question -> id_question) }}">
    		    			{{ csrf_field() }}
    		    			{{ method_field('DELETE') }}

    		    			<input type="submit" class="btn btn-danger" value="Eliminar">
    		    		</form>
    		    	</td>
    		    </tr>
    		@endforeach
    	</table>
        <a href="{{ route('questions.create') }}" class="btn btn-link" >crear mas preguntas</a>
    </div>
@stop