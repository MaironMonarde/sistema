<!--Barra de notificacion cuando se crea, edita o eliminan datos-->
<h1>{{$modo}} empleado </h1>

@if(count($errors)>0)  
<div class="alert alert-danger" role="alert">
    <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
@endforeach
</ul>
</div>
@endif
<!--Barra de notificacion cuando se crea, edita o eliminan datos-->


<!--campos para rellenar datos para crear y editar empleados-->
                                                                          <!--En caso de edicion, conserva los datos-->
<div class="form-group">                                                  <!--en el servidor para que se encuentren-->
<label for="Nombre"> Nombre </label>                                      <!--visibles al momento de cambiarlos-->
<input type="text" class="form-control" name="Nombre" value="{{ isset ($empleado->Nombre) ?$empleado->Nombre:old('Nombre') }}" id="Nombre">
</div>                                                                                           <!--old se refiere a que si estabas-->
                                                                                                 <!--ingresando datos y refrescaste-->                                       
<div class="form-group">                                                                         <!--la pagina estos se conserven-->
<label for="ApellidoPaterno"> Apellido Paterno </label>
<input type="text" class="form-control" name="ApellidoPaterno" value="{{ isset($empleado->ApellidoPaterno) ?$empleado->ApellidoPaterno:old('ApellidoPaterno') }}" id="ApellidoPaterno">
</div>

<div class="form-group">
<label for="ApellidoMaterno"> Apellido Materno </label>
<input type="text" class="form-control" name="ApellidoMaterno" value="{{ isset($empleado->ApellidoMaterno)? $empleado->ApellidoMaterno:old('ApellidoMaterno') }}" id="ApellidoMaterno">
</div>

<div class="form-group">
<label for="Correo"> Correo </label>
<input type="text" class="form-control" name="Correo" value="{{ isset ($empleado->Correo)? $empleado->Correo:old('Correo')}}" id="Correo">
</div>

<div class="form-group">
<label for="Foto"> Foto </label>
@if(isset($empleado->Foto))
<img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto }}" width="100" alt="">
@endif
<input type="file" class="form-control" name="Foto" value="" id="Foto">
<br>
</div>
<!--campos para rellenar datos para crear y editar empleados-->

<input class="btn btn-success" type="submit" value="{{$modo}} datos">
<a class="btn btn-primary" href= "{{url('empleado/')}}"> Regresar </a>
<br>