


<div class="d-inline-flex align-items-center flex-nowrap">
    <a href="{{ route('professor.show', $professor) }}" class="btn btn-sm btn-info p-1 mr-1" title="Detalhes">
        <x-bx-detail width="14" height="14" />
    </a>

    <a href="{{ route('professor.edit', $professor) }}" class="btn btn-sm btn-warning p-1 mr-1" title="Editar">
        <x-bx-pencil width="14" height="14" />
    </a>

    <form action="{{ route('professor.destroy', $professor) }}" method="POST" class="d-inline mb-0" data-confirm-delete>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger p-1" title="Excluir">
            <x-bx-trash width="14" height="14" />
        </button>
    </form>
</div>
