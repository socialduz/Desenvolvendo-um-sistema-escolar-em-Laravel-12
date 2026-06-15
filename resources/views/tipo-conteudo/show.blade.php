<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Tipo de Conteúdo</span>-Detalhes</h3>
                <a class="btn btn-primary" href="{{ route('tipo-conteudo.index') }}">Listar Tipos</a>
            </div>

            <div class="col-12 my-5">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Tipo</label>
                            <p class="form-control-plaintext border-bottom">{{ $tipoConteudo->tipo }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Status</label>
                            <p class="form-control-plaintext border-bottom">{{ (int) $tipoConteudo->status === 1 ? 'Ativo' : 'Inativo' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Data de criação</label>
                            <p class="form-control-plaintext border-bottom">{{ $tipoConteudo->dt_create ? date('d/m/Y', strtotime($tipoConteudo->dt_create)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Última alteração</label>
                            <p class="form-control-plaintext border-bottom">{{ $tipoConteudo->dt_update ? date('d/m/Y', strtotime($tipoConteudo->dt_update)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <label class="font-weight-bold">Disciplinas relacionadas</label>
                        @if ($disciplinas->isEmpty())
                            <p class="form-control-plaintext text-muted mb-0">Nenhuma disciplina vinculada a este tipo de conteúdo.</p>
                        @else
                            <ul class="list-group mt-2">
                                @foreach ($disciplinas as $disciplina)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">{{ $disciplina->nome }}</span>
                                        <span class="badge badge-{{ (int) $disciplina->status === 1 ? 'success' : 'secondary' }}">
                                            {{ (int) $disciplina->status === 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="col-12 mt-4">
                        <label class="font-weight-bold">Conteúdos deste tipo</label>
                        @if ($tipoConteudo->conteudos->isEmpty())
                            <p class="form-control-plaintext text-muted mb-0">Nenhum conteúdo cadastrado para este tipo.</p>
                        @else
                            <ul class="list-group mt-2">
                                @foreach ($tipoConteudo->conteudos as $conteudo)
                                    <li class="list-group-item">
                                        <span class="font-weight-bold">{{ $conteudo->titulo }}</span>
                                        <span class="text-muted ml-2">| Disciplina: {{ $conteudo->disciplina?->nome ?? '-' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="col-12 d-flex justify-content-end align-items-center flex-nowrap mt-4">
                        <a href="{{ route('tipo-conteudo.edit', $tipoConteudo) }}" class="btn btn-warning p-1 mr-2" title="Editar">
                            <x-bx-pencil width="14" height="14" />
                        </a>

                        <form action="{{ route('tipo-conteudo.destroy', $tipoConteudo) }}" method="POST" class="d-inline mb-0" data-confirm-delete>
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
