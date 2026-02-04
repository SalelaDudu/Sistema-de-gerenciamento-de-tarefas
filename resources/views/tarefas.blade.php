@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-primary">Minhas Tarefas</h2>
    </div>
    <div class="col-md-6 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCriarTarefa">
            <i class="bi bi-plus-lg"></i> Adicionar Tarefa
        </button>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome da Tarefa</th>
                        <th>Custo (R$)</th>
                        <th>Data Limite</th>
                        <th class="text-center">Ordem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarefas as $tarefa)
                        <tr> <td>{{ $tarefa->id }}</td>
                            <td class="fw-bold">{{ $tarefa->nome }}</td>
                            <td>R$ {{ number_format($tarefa->custo, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($tarefa->data_limite)->format('d/m/Y') }}</td>
                            
                            <td class="text-center bg-light">
                                <div class="d-flex justify-content-center gap-1">
                                    @unless($loop->first)
                                        <a href="{{ url('/tarefas/'.$tarefa->id.'/up') }}" class="btn btn-sm btn-outline-secondary" title="Subir Prioridade">
                                            <i class="bi bi-arrow-up"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary disabled" disabled><i class="bi bi-arrow-up"></i></button>
                                    @endunless

                                    <span class="fw-bold px-2 align-self-center">{{ $tarefa->ordem_apresentacao }}</span>

                                    @unless($loop->last)
                                        <a href="{{ url('/tarefas/'.$tarefa->id.'/down') }}" class="btn btn-sm btn-outline-secondary" title="Descer Prioridade">
                                            <i class="bi bi-arrow-down"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary disabled" disabled><i class="bi bi-arrow-down"></i></button>
                                    @endunless
                                </div>
                            </td>
                            
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $tarefa->id }}" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir{{ $tarefa->id }}" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEditar{{ $tarefa->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Editar Tarefa: {{ $tarefa->nome }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ url('/') }}" method="POST">
                                        @csrf
                                        @method('PUT') <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nome</label>
                                                <input type="text" class="form-control" name="nome" value="{{ $tarefa->nome }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Custo (R$)</label>
                                                <input type="number" step="0.01" min="0" class="form-control" name="custo" value="{{ $tarefa->custo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Data Limite</label>
                                                <input type="date" class="form-control" name="data_limite" value="{{ $tarefa->data_limite }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalExcluir{{ $tarefa->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem certeza que deseja excluir a tarefa <strong>{{ $tarefa->nome }}</strong>?</p>
                                        <p class="text-muted small">Essa ação não pode ser desfeita.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ url('/tarefas/'.$tarefa->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Sim, Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-x display-6"></i>
                                <p class="mt-2">Nenhuma tarefa encontrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
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
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="custo" class="form-label">Custo (R$) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" name="custo" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_limite" class="form-label">Data Limite <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="data_limite" required>
                    </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection