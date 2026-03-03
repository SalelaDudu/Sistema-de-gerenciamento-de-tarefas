<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Models\TarefasModel;

class TarefasController extends Controller
{
    public function listarTarefas(){
        return view('tarefas',["tarefas"=>TarefasModel::listarTarefas()]);
    }

    public function incluir(Request $request){
        // Validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|unique:tarefas,nome',],
            ['nome.unique' => 'Erro - tarefas não podem conter nomes repetidos',]);
                // caso de erro retona mensagem
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $validator->errors()->first('nome'));
                }
        TarefasModel::inserir($request->input('nome'),$request->input('custo'),$request->input('data_limite'));
        return redirect()->back()->with('success', 'Tarefa inserida com sucesso!');

    }

    public function excluir($id){
        TarefasModel::excluir($id); 
        return redirect()->back()->with('success', 'Tarefa excluída com sucesso!');
    }

    public function editar(Request $request, $id) {
        // Verificação de nome único
        $validator = Validator::make($request->all(), ['nome' => "required|unique:tarefas,nome,{$id}|max:255",
        'custo' => 'required|numeric','data_limite' => 'required|date',],
        [
            'nome.unique' => 'Erro - tarefas não podem conter nomes repetidos',
            'nome.max' => 'Erro - o nome não pode ter mais de 255 caracteres',
        ]);

        // retorno de erro
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validator->errors()->first('nome'));
        }

        // Edição caso bem sucedido
        TarefasModel::editar($id, $request->input('nome'), $request->input('custo'), $request->input('data_limite'));

        return redirect()->back()->with('success', 'Tarefa alterada com sucesso!');
    }

    public function reordernacaoDasTarefas(Request $request){
        TarefasModel::reordernacaoDasTarefas($request->input('ordem'));
        return response()->json(['status' => 'success']);
    }
}