@extends('layouts.app')

@section('title', 'Tarefas')

@section('content')

<style>
    .alerta-custo {
        border: 2px solid #fd7e14 !important;
    }
    .alerta-custo td {
        background-color: #fff3cd !important;
    }
</style>

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
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">Ordem</th>
                        <th>ID</th>
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
                            <td class="celula-custo" data-custo="{{ $tarefa->custo }}">R$ {{ number_format($tarefa->custo, 2, ',', '.') }}</td>
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
                            <td colspan="6" class="text-center py-5 text-muted">Nenhuma tarefa encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total:</td>
                        <td colspan="3" class="fw-bold text-primary" id="total-custo-rodape">R$ 0,00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCriarTarefa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nova Tarefa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/incluir-tarefa') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nome</label><input type="text" class="form-control" name="nome" maxlength="255" required><small class="text-muted">Máximo 255 caracteres.</small></div>
                    <div class="mb-3"><label class="form-label">Custo</label><input type="number" step="0.01" min="0" class="form-control" name="custo" required></div>
                    <div class="mb-3"><label class="form-label">Data</label><input type="date" class="form-control" name="data_limite" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($tarefas as $tarefa)
    <div class="modal fade" id="modalEditar{{ $tarefa->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Editar: {{ $tarefa->nome }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('/editar-tarefa/'.$tarefa->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Nome</label><input type="text" class="form-control" name="nome" maxlength="255" value="{{ $tarefa->nome }}" required><small class="text-muted">Máximo 255 caracteres.</small></div>
                        <div class="mb-3"><label class="form-label">Custo</label><input type="number" step="0.01" min="0" class="form-control" name="custo" value="{{ $tarefa->custo }}" required></div>
                        <div class="mb-3"><label class="form-label">Data</label><input type="date" class="form-control" name="data_limite" value="{{ $tarefa->data_limite }}" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExcluir{{ $tarefa->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Excluir Tarefa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir <strong>{{ $tarefa->nome }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ url('/excluir-tarefa/'.$tarefa->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('lista-tarefas-body');
        
        let total = 0;
        document.querySelectorAll('.celula-custo').forEach(function (celula) {
            let valor = parseFloat(celula.getAttribute('data-custo'));
            if (!isNaN(valor)) {
                total += valor;
                if (valor >= 1000) {
                    celula.closest('tr').classList.add('alerta-custo');
                }
            }
        });
        
        let totalElement = document.getElementById('total-custo-rodape');
        if(totalElement) {
            totalElement.innerText = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        if(el){
            new Sortable(el, {
                handle: '.handle',
                animation: 150,
                onEnd: function (evt) {
                    var ordenacao = [];
                    document.querySelectorAll('#lista-tarefas-body tr').forEach((row) => {
                        ordenacao.push(row.getAttribute('data-id'));
                    });

                    fetch("/ordenar-tarefa", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ ordem: ordenacao })
                    }).catch(error => console.error('Erro:', error));
                }
            });
        }
    });
</script>

@endsection