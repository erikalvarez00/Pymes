@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="container form-group">
         <h2>Editar</h2>
         <form method="POST" action="{{route('users.store')}}">
            <div>
               <label for="lbl_nombre">Nombre</label>
               <input type="text" name="nombre" id="lbl_nombre" class="form-control">
            </div>
            <div>
               <label for="lbl_apellidoP">Apellido paterno</label>
               <input type="text" name="apellidoP" id="lbl_apellidoP" class="form-control">
            </div>
            <div>
               <label for="lbl_apellidoM">Apellido materno</label>
               <input type="text" name="apellidoM" id="lbl_apellidoM" class="form-control">
            </div>
            <div>
               <label for="lbl_email">Email</label>
               <input type="text" name="email" id="lbl_email" class="form-control">
            </div>
            <div>
               <label for="lbl_rol">Rol</label>
               <select class="form-control" name="id_role" id="lbl_rol" >
                  <option value="1">Administrador</option>
                  <option value="2">Alumno encargado</option>
                  <option value="3">Alumno</option>
               </select>
            </div>
            <div>
               <label for="lbl_equipo">Equipo</label>
               <input type="text" name="equipo" id="lbl_equipo" class="form-control" >
            </div>
            <br>
            <input type="submit" value="Aceptar" class="btn btn-info" method="POST">
            {{ csrf_field() }}
         </form>
      </div>
   </div>
</div>
</div>
@endsection