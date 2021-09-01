<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
//use App\Http\Controllers\EventosController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'LoginController@index')->name('login');

Route::post('/login', 'LoginController@authenticate');
Route::get('/logout', 'LoginController@logout');

Route::name('print')->get('/imprimir', 'EventosController@imprimir');
Route::name('generate')->get('/generar', 'EventosController@generar');


Route::post('guardar-evento', 'EventosController@guardarEvento');
Route::post('get-eventos', 'EventosController@getEventos');
Route::post('update-eventos', 'EventosController@updateEventos');
Route::post('eliminar-evento', 'EventosController@eliminarEvento');
Route::get('/', 'EventosController@mostrarHome')->middleware('auth');

Route::get('evento', function (){
    return view('evento');
});

Route::get('/reportes', function(){
    return view('reportes');
});

/*
Route::post('/get', function(Request $request){

    $usuario = $request->username;
    $contra = $request->password;

    $exito = false;

    if($usuario == 'jose' && $contra == 'aispuro'){
        $exito = true;
    }


    return response()->json(['user' => $usuario, 'contra' => $contra, 'exito' => $exito]);
});*/