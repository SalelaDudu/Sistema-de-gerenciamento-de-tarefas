<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                Gerenciador de Tarefas
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('tarefas') ? 'active' : '' }}" href="{{ url('/tarefas') }}">Tarefas</a>
                    </li>            
                </ul>
            </div>
        </div>
    </nav>
</header>