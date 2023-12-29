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
Route::get('imprimir', 'PublicController@imprimir');


Route::group(['prefix' => 'admin'], function() {

    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@authenticate');
    Route::get('/logout', 'LoginController@logout')->middleware('auth');

    Route::group(["middleware" => "auth"], function () {

        Route::name('print')->get('/imprimir', 'EventosController@imprimir');
        Route::name('generate')->get('/generar', 'EventosController@generar');


        Route::post('guardar-evento', 'EventosController@guardarEvento');
        Route::post('get-eventos', 'EventosController@getEventos');
        Route::post('get-evento', 'EventosController@getEvento');
        Route::post('update-eventos', 'EventosController@updateEventos');
        Route::post('eliminar-evento', 'EventosController@eliminarEvento');
        Route::get('/', 'EventosController@mostrarHome');

        //Route::get('evento/{id}', 'EventosController@mostrarEvento');

        Route::view('evento', 'evento');
        Route::view('/reportes', 'reportes');
    });
});
