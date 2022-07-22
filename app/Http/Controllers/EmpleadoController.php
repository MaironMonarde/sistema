<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recibe de la bd los 5 primeros registros
        $datos['empleados']=Empleado::paginate(5);

        //retornar a vista
        return view('empleado.index',$datos);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //retorna a vista
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //limitacion de caracteres con sus validaciones 

        $campos = [
            'Nombre'=>'required|string|max:15',
            'ApellidoPaterno'=>'required|string|max:15',
            'ApellidoMaterno'=>'required|string|max:15',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg',

        ];
        //en caso de algun error mandara un mensaje
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida'

        ];
        //une los arreglos establecidos anteriormente
        $this->validate($request,$campos,$mensaje);


        //recepcion de info del empleado menos el token
        $datosEmpleado = request()->except('_token');

        //valida si hay una foto
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        //se insertan los datos en el modelo de empleado
        Empleado::insert($datosEmpleado);

        //retorna a empleado(index) acompañado de un mensaje 
        return redirect('empleado')->with('mensaje','Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //buscar un registro con el id del empleado seleccionado
        $empleado=Empleado::findOrFail($id);

        //retorna a la vista con todos los datos del empleado
        return view('empleado.edit', compact('empleado') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //limitacion de caracteres con sus validaciones 
        $campos = [
            'Nombre'=>'required|string|max:15',
            'ApellidoPaterno'=>'required|string|max:15',
            'ApellidoMaterno'=>'required|string|max:15',
            'Correo'=>'required|email',
            

        ];
        //en caso de algun error mandara un mensaje
        $mensaje=[
            'required'=>'El :attribute es requerido',


        ];
        //valida que los campos sean rellenados con dichas restricciones
        if($request->hasFile('Foto')){
           $campos= ['Foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
           
           //mensaje de alerta de falta de foto
           $mensaje=['Foto.required'=>'La foto es requerida'];
        }
        //une los arreglos establecidos anteriormente
        $this->validate($request,$campos,$mensaje);

        //recepcion de la informacion del empleado menos el token ni metodo
        $datosEmpleado = request()->except(['_token','_method']);

        //valida si la foto existe 
        if($request->hasFile('Foto')){
            //recuperar informacion del empleado por id
            $empleado=Empleado::findOrFail($id);
            
            //desde la foto concatena y borra por el enlace
            Storage::delete('public/'.$empleado->Foto);
            
            //actualiza la foto nueva en la carpeta uploads
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        
        //busca el registro del id para actualizar los datos ya recepcionados
        Empleado::where('id','=',$id)->update($datosEmpleado);
        
        //busca la informacion del empleado por la id
        $empleado=Empleado::findOrFail($id);
        
        //retorna a empleado(index) indicando posteriormente un mensaje
        return redirect('empleado')->with('mensaje','Empleado modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //busca la info del empleado por el id
        $empleado=Empleado::findOrFail($id);

        //borra desde la direccion establecida
        if(Storage::delete('public/'.$empleado->Foto)){
            
            //borra el registro
            Empleado::destroy($id);
        }

        //retorna a empleado(index) indicando posteriormente un mensaje 
        return redirect('empleado')->with('mensaje','Empleado borrado con éxito');
    }
}
