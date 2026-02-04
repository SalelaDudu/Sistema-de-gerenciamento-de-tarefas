<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TarefasModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "Tarefas";

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
}
