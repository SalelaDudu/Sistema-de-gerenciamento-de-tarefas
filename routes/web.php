<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TarefasController;

Route::get('/', function () {
    return view('index');
});


Route::controller(TarefasController::class)->group(function (){

Route::get('/tarefas','listarTarefas');

Route::post('/incluir-tarefa', 'incluir');
Route::delete('/excluir-tarefa/{id}', 'excluir');
Route::put('/editar-tarefa/{id}', 'editar');
Route::post('/ordenar-tarefa','reordernacaoDasTarefas');


});