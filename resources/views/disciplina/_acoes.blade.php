<div class="d-inline-flex align-items-center flex-nowrap">
    <a href="{{ route('disciplina.show', $disciplina->id) }}" class="btn btn-sm btn-info p-1 mr-1" title="Detalhes">
        <x-bx-detail width="14" height="14" />
    </a>

    <a href="{{ route('disciplina.edit', $disciplina->id) }}" class="btn btn-sm btn-warning p-1 mr-1" title="Editar">
        <x-bx-pencil width="14" height="14" />
    </a>

    <a href="{{ route('disciplina.conteudos', $disciplina->id) }}" class="btn btn-sm btn-success p-1" title="Conteúdos">
        <x-bx-book width="14" height="14" />
    </a>
</div>
