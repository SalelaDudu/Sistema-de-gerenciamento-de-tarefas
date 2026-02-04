@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
    <div class="container h-100 d-flex justify-content-center align-items-center">
        
        <div class="card shadow-lg border-0 text-center" style="width: 22rem; border-radius: 15px;">
            <div class="card-body p-5">
                
                <div class="mb-4 text-primary">
                    <i class="bi bi-list-check" style="font-size: 4rem;"></i>
                </div>

                <h3 class="card-title fw-bold mb-3">Minhas Tarefas</h3>
                <p class="card-text text-muted mb-4">
                    Organize seu dia, gerencie custos e prazos de forma simples e rápida.
                </p>

                <a href="{{ url('/tarefas') }}" class="btn btn-primary btn-lg w-100 rounded-pill">
                    Acessar Lista
                </a>
                
            </div>
        </div>

    </div>
@endsection