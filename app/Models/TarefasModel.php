<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class TarefasModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tarefas";

    public static function listarTarefas(){
        return TarefasModel::select("*")->get();
    }
    
    public static function inserir($nome,$custo,$data_limite){
        $posicao = TarefasModel::max('ordem_apresentacao') + 1;    
        $tarefa = new TarefasModel();
        $tarefa->nome = $nome;
        $tarefa->custo = $custo;
        $tarefa->data_limite = $data_limite;
        $tarefa->ordem_apresentacao = $posicao;
        $tarefa->save();
    }

    public static function excluir($id){
        TarefasModel::where('id',$id)->delete();
    }

    public static function editar($id,$nome,$custo,$data_limite){
        $tarefa = TarefasModel::findOrFail($id);
        $tarefa->nome = $nome;
        $tarefa->custo = $custo;
        $tarefa->data_limite = $data_limite;

        $tarefa->save();
    }

    public static function reordernacaoDasTarefas(array $ordem)
    {
        DB::transaction(function () use ($ordem) {
            foreach ($ordem as $posicaoIndex => $idTarefa) {
                static::where('id', $idTarefa)->update([
                    'ordem_apresentacao' => $posicaoIndex + 1
                ]);
            }
        });
    }
}
