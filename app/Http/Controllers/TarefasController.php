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
        return redirect()->back()->with('success', 'Tarefa inserida com sucesso!');

    }
    public function excluir($id){
        TarefasModel::excluir($id); 
        return redirect()->back()->with('success', 'Tarefa excluída com sucesso!');
    }
    public function editar(Request $request, $id){
        TarefasModel::editar($id, $request->input('nome'), $request->input('custo' ),$request->input('data_limite'));
        return redirect()->back()->with('success', 'Tarefa alterada com sucesso!');
    }

    public function reordernacaoDasTarefas(Request $request){
        TarefasModel::reordernacaoDasTarefas($request->input('ordem'));
        return response()->json(['status' => 'success']);
    }
}
