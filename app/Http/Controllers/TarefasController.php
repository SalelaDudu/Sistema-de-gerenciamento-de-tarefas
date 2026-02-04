<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\TarefasModel;

class TarefasController extends Controller
{
    public function listarTarefas(){
        return view('tarefas',["tarefas"=>TarefasModel::listarTarefas()]);
    }

    public function incluir(Request $request){
        TarefasModel::inserir($request->input('nome'),$request->input('custo'),$request->input('data_limite'));
        return redirect('/tarefas');
    }
}
