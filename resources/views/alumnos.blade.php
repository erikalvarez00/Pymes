@extends('layouts.app')
@section('content')
<div class="container">
   <!-- Modal -->

   <h2>Registros</h2>
   <table class="table table-hover">
      <thead>
         <tr>
            <th>Nombre</th>
            <th>Apellido paterno</th>
            <th>Apellido materno</th>
            <th>Correo</th>
            <th>Equipo</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         @foreach($estudiantes as $item)
            <td>{{$item->nombre}}</td>
            <td>{{$item->apellidoP}}</td>
            <td>{{$item->apellidoM}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->equipo}}</td>
            <td>
               <div class="d-inline">
                  <a class="btn btn-info" href="{{route('users.show',$item->id)}}" >Ver</a>
               </div>
               <div class="d-inline">
                  <a  class="btn btn-warning" href="{{route('users.edit',$item->id)}}">Editar</a>
               </div>
               <form action="{{route('users.destroy',$item->id)}}" method="post" class="d-inline">
                  <button type="button"  class="btn btn-danger"  data-toggle="modal" data-target="#exampleModalCenter" >Eliminar</button>
                  {{ csrf_field() }}
                  {{ method_field('DELETE')}}
                  <!--Modal validacion de boton eliminar-->
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Confirmar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              ¿Seguro que deseas eliminar el registro?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Eliminar</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </td>
            <!--td><a href="/Administrador/{{$item->id}}/mostrar" </a>Detalles</td-->
         </tr>
         @endforeach
      </tbody>
      <!--a href="{{route('register')}}">Agregar alumno</a-->
      <!--a href="{{ route('register') }}" class="btn btn-info">Agregar Usuario</a-->
      <!-- Button trigger modal --> 


   </table>
   {{ $estudiantes->render() }}
</div>

<!--a class="btn btn-info" href="">Registrar usuario</a-->
<script src="{{ asset('js/app.js') }}"></script>
@endsection