<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
}) -> name('home');

Auth::routes();

Route::get('/userStatus', 'HomeController@index')->name('userStatus');

Route::get('/cursos', 'CursosController@listarCursos')->name('cursos');

Route::get('/cursos/crear', 'CursosController@mostrarFormularioCrearCursos')->name('formCursos');
Route::post('/cursos/crear', 'CursosController@cargarCurso')->name('formCursosPost');

Route::get('/cursos/{curso}/actualizar', 'CursosController@editarCurso')->name('cursos.editar');
Route::patch('/cursos/{curso}', 'CursosController@actualizarCurso')->name('cursos.actualizar');

Route::delete('/cursos/{id}', 'CursosController@eliminarCurso')->name('cursos.eliminar');

Route::get('/cursos/{curso}/inscribir', 'CursosController@inscribirEnCurso')->name('cursos.inscribir');


// API REST
Route::get('/api', 'CursosController@index')->name('gettokenAPI'); // token
Route::post('/api/cursos', 'CursosController@createCurso')->name('postCursosAPI'); // crear curso
Route::get('/api/cursos', 'CursosController@getCursos')->name('getCursosAPI'); // obtener todos los cursos
Route::get('/api/cursos/{id}', 'CursosController@getCursoPorID')->name('getCursoEspecificoAPI'); // obtener un curso especifico
Route::post('/api/cursos/{id}', 'CursosController@updateCurso')->name('updateCursoEspecificoAPI'); // editar curso
Route::delete('/api/cursos/{id}', 'CursosController@deleteCurso')->name('deleteCursoAPI'); // eliminar curso

Route::get('/api/user/{id}', 'CursosController@cursosInscriptosDelUsuario')->name('getCursosDelUsuarioAPI'); // cursos a los que está inscripto el usuario