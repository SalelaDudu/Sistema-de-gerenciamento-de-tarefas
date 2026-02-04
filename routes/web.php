<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TarefasController;

Route::get('/', function () {
    return view('index');
});


Route::controller(TarefasController::class)->group(function (){

Route::get('/tarefas','listarTarefas');

Route::post('/incluir-tarefa', 'incluir');
});