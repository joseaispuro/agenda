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

Route::get('', 'PublicController@index');
Route::post('get-eventos-public', 'PublicController@getEventos');


Route::group(['prefix' => 'admin'], function() {

    Route::get('/login', 'LoginController@index')->name('login');

    Route::post('/login', 'LoginController@authenticate');
    Route::get('/logout', 'LoginController@logout')->middleware('auth');

    Route::name('print')->get('/imprimir', 'EventosController@imprimir')->middleware('auth');
    Route::name('generate')->get('/generar', 'EventosController@generar')->middleware('auth');


    Route::post('guardar-evento', 'EventosController@guardarEvento')->middleware('auth');
    Route::post('get-eventos', 'EventosController@getEventos')->middleware('auth');
    Route::post('get-evento', 'EventosController@getEvento')->middleware('auth');
    Route::post('update-eventos', 'EventosController@updateEventos')->middleware('auth');
    Route::post('eliminar-evento', 'EventosController@eliminarEvento')->middleware('auth');
    Route::get('/', 'EventosController@mostrarHome')->middleware('auth');

    //Route::get('evento/{id}', 'EventosController@mostrarEvento')->middleware('auth');

    Route::get('evento', function (){
        return view('evento');
    })->middleware('auth');

    Route::get('/reportes', function(){
        return view('reportes');
    })->middleware('auth');

});
