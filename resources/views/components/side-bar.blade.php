<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <i class="fas fa-graduation-cap fa-4x"></i>
        <div class="sidebar-brand-text mx-3">Sistema Escolar</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('escola.index') }}">
            <i class="fas fa-school"></i>
            <span>Escola</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('curso.index') }}">
            <i class="fas fa-university"></i>
            <span>Cursos</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('turma.index') }}">
            <i class="fas fa-user-graduate"></i>
            <span>Turmas</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('tipo-conteudo.index') }}">
            <i class="fas fa-window-restore"></i>
            <span>Tipo de Conteúdo</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('usuario.index') }}">
            <i class="fas fa-users"></i>
            <span>Usuários</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('administrativo.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Administrativo</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cargo.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Cargo</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('professor.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Professores</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->
