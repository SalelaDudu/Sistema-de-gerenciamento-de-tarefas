@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col-md-6"><h2 class="fw-bold text-primary">Minhas Tarefas</h2></div>
    <div class="col-md-6 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCriarTarefa">
            <i class="bi bi-plus-lg"></i> Adicionar
        </button>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 align-middle" id="tabelaTarefas">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">Ordem</th> <th>ID</th>
                        <th>Nome da Tarefa</th>
                        <th>Custo (R$)</th>
                        <th>Data Limite</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="lista-tarefas-body">
                    @forelse($tarefas as $tarefa)
                        <tr data-id="{{ $tarefa->id }}" class="item-tarefa">
                            
                            <td class="text-center" style="cursor: move;">
                                <i class="bi bi-grip-vertical text-secondary fs-4 handle"></i>
                            </td>

                            <td>{{ $tarefa->id }}</td>
                            <td class="fw-bold">{{ $tarefa->nome }}</td>
                            <td>R$ {{ number_format($tarefa->custo, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($tarefa->data_limite)->format('d/m/Y') }}</td>
                            
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $tarefa->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir{{ $tarefa->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Nenhuma tarefa encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('lista-tarefas-body');
        
        var sortable = Sortable.create(el, {
            handle: '.handle', 
            animation: 150,   
            
            // Evento disparado quando o usuário solta o item
            onEnd: function (evt) {
                var ordenacao = sortable.toArray(); 
                
                fetch("{{ url('/ordenar-tarefa') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                    },
                    body: JSON.stringify({
                        ordem: ordenacao 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Ordem salva com sucesso!', data);
                })
                .catch((error) => {
                    console.error('Erro ao salvar ordem:', error);
                    alert('Erro ao reordenar tarefas.');
                });
            }
        });
    });
</script>

@endsection