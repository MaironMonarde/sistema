<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Auth;

/*Esta es la ruta inicial*/
Route::get('/', function () {
    return view('auth.login');
});


/*Permite acceder a todas las rutas que han sido creadas, 
pero ingresar a ellas tiene que ingresar primero a su cuenta*/
Route::resource('empleado', EmpleadoController::class)->middleware('auth');


/*Estas son rutas que estan ocultas*/
Auth::routes(['register'=>false,'reset'=>false]);

/*Esta ruta se le asigna cuando ha iniciado sesión */
Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

/*Grupo de rutas luego de haber realizado su funcion vuelven al home*/
Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});