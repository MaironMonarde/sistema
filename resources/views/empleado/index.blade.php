@extends('layouts.app')<!-- Esta es una extension de bootstrap -->
@section('content') <!-- seccion que incluye los elementos de bootstrap -->
<div class="container">

    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
    {{Session::get('mensaje')}}
        <button type="button" class= "btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>

        </button>

</div>

    @endif




<a href= "{{url('empleado/create')}}" class="btn btn-success"> Registrar nuevo empleado</a>
<br/>
<br/>
<h1>Lista de empleados</h1>

<!-- Esta parte representa a los datos a mostrar del empleado -->
<!-- -->   <table class="table table-light">             <!-- -->
<!-- -->       <thead class="thead-info">                <!-- -->
<!-- -->           <tr>                                  <!-- -->
<!-- -->               <th>#</th>                        <!-- -->
<!-- -->               <th>Foto</th>                     <!-- -->
<!-- -->               <th>Nombre</th>                   <!-- -->
<!-- -->               <th>Apellido Paterno</th>         <!-- -->
<!-- -->               <th>Apellido Materno</th>         <!-- -->
<!-- -->               <th>Correo</th>                   <!-- -->
<!-- -->               <th>Acciones</th>                 <!-- -->
<!-- Esta parte representa a los datos a mostrar del empleado -->

                   </tr>
               </thead>
    <tbody>

        
        <!-- Consulta la informacion con un blade a un foreach --> 
        <!-- Posteriormente lee los datos de la variable --> 
        @foreach($empleados as $empleado)
        <tr>
            <td>{{$empleado->id}}</td>
            <td>
                <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto }}" width="100" alt="">
            </td>
            <td>{{$empleado->Nombre}}</td>
            <td>{{$empleado->ApellidoPaterno}}</td>
            <td>{{$empleado->ApellidoMaterno}}</td>
            <td>{{$empleado->Correo}}</td>
            <td>
        <!-- Consulta la informacion con un blade a un foreach --> 
        <!-- Posteriormente lee los datos de la variable --> 

                
                <!--Boton para editar empleado con su respectivo enlace--> 
                <a href="{{url('/empleado/'.$empleado->id.'/edit')}}" class="btn btn-warning">
                Editar 
                </a>

                | 
                <!--Boton para borrar con su respectivo enlace--> 
                <form action="{{url('/empleado/'.$empleado->id)}}" class="d-inline" method="post">
                
                <!--Metodo de seguriad para validacion de datos--> 
                @csrf  
                {{method_field('delete')}} 
                <input class ="btn btn-danger " type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar">
                <!--Boton para borrar con su respectivo enlace--> 
                </form>

            
            
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!!$empleados->links() !!}
</div>
@endsection