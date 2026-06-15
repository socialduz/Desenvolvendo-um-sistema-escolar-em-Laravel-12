<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Cargo</span>-Detalhes</h3>
                <a class="btn btn-primary" href="{{ route('cargo.index') }}">Listar Cargos</a>
            </div>

            <div class="col-12 my-5">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Título</label>
                            <p class="form-control-plaintext border-bottom">{{ $cargo->titulo }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Status</label>
                            <p class="form-control-plaintext border-bottom">{{ (int) $cargo->status === 1 ? 'Ativo' : 'Inativo' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Data de criação</label>
                            <p class="form-control-plaintext border-bottom">{{ $cargo->dt_create ? date('d/m/Y', strtotime($cargo->dt_create)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Última alteração</label>
                            <p class="form-control-plaintext border-bottom">{{ $cargo->dt_update ? date('d/m/Y', strtotime($cargo->dt_update)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Descrição</label>
                            <p class="form-control-plaintext border-bottom">{{ $cargo->descricao }}</p>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end align-items-center flex-nowrap mt-4">
                        <a href="{{ route('cargo.edit', $cargo) }}" class="btn btn-warning p-1 mr-2" title="Editar">
                            <x-bx-pencil width="14" height="14" />
                        </a>

                        <form action="{{ route('cargo.destroy', $cargo) }}" method="POST" class="d-inline mb-0" data-confirm-delete>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger p-1" title="Excluir">
                                <x-bx-trash width="14" height="14" />
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
