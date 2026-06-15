<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Disciplina</span>-Detalhes</h3>
                <a class="btn btn-primary" href="{{ route('disciplina.index') }}">Listar Disciplinas</a>
            </div>

            <div class="col-12 my-5">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Nome</label>
                            <p class="form-control-plaintext border-bottom">{{ $disciplina->nome }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Status</label>
                            <p class="form-control-plaintext border-bottom">{{ (int) $disciplina->status === 1 ? 'Ativo' : 'Inativo' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Data de cadastro</label>
                            <p class="form-control-plaintext border-bottom">{{ $disciplina->dt_cadastro ? date('d/m/Y', strtotime($disciplina->dt_cadastro)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Data de criação</label>
                            <p class="form-control-plaintext border-bottom">{{ $disciplina->dt_create ? date('d/m/Y', strtotime($disciplina->dt_create)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <label>Última alteração</label>
                            <p class="form-control-plaintext border-bottom">{{ $disciplina->dt_update ? date('d/m/Y', strtotime($disciplina->dt_update)) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Descrição</label>
                            <p class="form-control-plaintext border-bottom">{{ $disciplina->descricao }}</p>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <label class="font-weight-bold">Conteúdos relacionados</label>
                        @if ($disciplina->conteudos->isEmpty())
                            <p class="form-control-plaintext text-muted mb-0">Nenhum conteúdo vinculado a esta disciplina.</p>
                        @else
                            <ul class="list-group mt-2">
                                @foreach ($disciplina->conteudos as $conteudo)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <span class="font-weight-bold">{{ $conteudo->titulo }}</span>
                                            <span class="text-muted ml-2">| {{ $conteudo->tipoConteudo?->tipo ?? '-' }}</span>
                                        </span>
                                        <span class="badge badge-{{ (int) $conteudo->status === 1 ? 'success' : 'secondary' }}">
                                            {{ (int) $conteudo->status === 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="col-12 d-flex justify-content-end align-items-center flex-nowrap mt-4">
                        <a href="{{ route('disciplina.edit', $disciplina) }}" class="btn btn-warning p-1" title="Editar">
                            <x-bx-pencil width="14" height="14" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
