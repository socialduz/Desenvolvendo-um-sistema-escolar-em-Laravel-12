<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Disciplina</span>-Cadastrar Conteúdo</h3>
                <a class="btn btn-primary" href="{{ route('disciplina.index') }}">Listar Disciplinas</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <div class="border-left-info bg-light rounded py-2 px-3 mb-4 small">
                    <span class="font-weight-bold text-info">Disciplina selecionada</span>
                    <p class="mb-0 mt-1 text-muted">{{ $disciplina->nome }}</p>
                </div>

                <div class="border-left-info bg-light rounded py-2 px-3 mb-3 small">
                    <span class="font-weight-bold text-info">Condições para cadastro</span>
                    <ul class="mb-0 mt-1 pl-3 text-muted">
                        @foreach ($condicoes as $condicao)
                            <li class="mb-0">{{ $condicao }}</li>
                        @endforeach
                    </ul>
                </div>

                <form method="POST" action="{{ route('disciplina.add-conteudos') }}">
                    @csrf
                    <input type="hidden" name="id_disciplina" value="{{ $disciplina->id }}">

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-0">
                                <label for="titulo">Título <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    type="text"
                                    name="titulo"
                                    id="titulo"
                                    value="{{ old('titulo') }}"
                                    maxlength="150"
                                    required
                                >
                                @error('titulo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group mb-0">
                                <label for="id_tipo">Tipo de conteúdo <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_tipo') is-invalid @enderror" name="id_tipo" id="id_tipo" required>
                                    <option value="">Selecione</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" @selected(old('id_tipo') == $tipo->id)>{{ $tipo->tipo }}</option>
                                    @endforeach
                                </select>
                                @error('id_tipo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group mb-0">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                    <option value="1" @selected(old('status', 1) == 1)>Ativo</option>
                                    <option value="0" @selected(old('status', 1) == 0)>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-0">
                                <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    type="text"
                                    name="descricao"
                                    id="descricao"
                                    value="{{ old('descricao') }}"
                                    maxlength="200"
                                    required
                                >
                                @error('descricao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-0">
                                <label for="observacao">Observação</label>
                                <input
                                    class="form-control @error('observacao') is-invalid @enderror"
                                    type="text"
                                    name="observacao"
                                    id="observacao"
                                    value="{{ old('observacao') }}"
                                >
                                @error('observacao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('disciplina.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar conteúdo</button>
                        </div>
                    </div>
                </form>

                <div class="text-left mt-5">
                    <button
                        class="btn btn-link p-0 mb-3 text-dark font-weight-bold text-left collapsed d-inline-flex align-items-center conteudos-toggle"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseConteudosLista"
                        aria-expanded="false"
                        aria-controls="collapseConteudosLista"
                    >
                        <i class="fas fa-chevron-down mr-2 conteudos-toggle-icon"></i>
                        Conteúdos cadastrados
                    </button>

                    <div id="collapseConteudosLista" class="collapse">
                        @if ($conteudos->isEmpty())
                            <p class="mb-0 text-muted text-left pl-4">Nenhum conteúdo cadastrado para esta disciplina.</p>
                        @else
                            <div class="accordion pl-2" id="accordionItensConteudo">
                                @foreach ($conteudos as $conteudo)
                                    <div class="card mb-2 border-left-primary">
                                        <div class="card-header py-2" id="headingConteudo{{ $conteudo->id }}">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left collapsed py-1 small"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#collapseConteudo{{ $conteudo->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseConteudo{{ $conteudo->id }}"
                                                >
                                                    <span class="font-weight-bold">{{ $conteudo->titulo }}</span>
                                                    <span class="text-muted ml-2">| {{ $conteudo->tipoConteudo?->tipo ?? '-' }}</span>
                                                    <span class="badge badge-{{ (int) $conteudo->status === 1 ? 'success' : 'secondary' }} ml-2">
                                                        {{ (int) $conteudo->status === 1 ? 'Ativo' : 'Inativo' }}
                                                    </span>
                                                </button>
                                            </h2>
                                        </div>

                                        <div
                                            id="collapseConteudo{{ $conteudo->id }}"
                                            class="collapse"
                                            aria-labelledby="headingConteudo{{ $conteudo->id }}"
                                            data-parent="#accordionItensConteudo"
                                        >
                                            <div class="card-body py-3 text-left small">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <span class="font-weight-bold">Descrição:</span>
                                                        <span class="d-block text-muted">{{ $conteudo->descricao }}</span>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <span class="font-weight-bold">Tipo de conteúdo:</span>
                                                        <span class="d-block text-muted">{{ $conteudo->tipoConteudo?->tipo ?? '-' }}</span>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <span class="font-weight-bold">Status:</span>
                                                        <span class="d-block text-muted">{{ (int) $conteudo->status === 1 ? 'Ativo' : 'Inativo' }}</span>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-2">
                                                        <span class="font-weight-bold">Observação:</span>
                                                        <span class="d-block text-muted">{{ $conteudo->observacao ?: '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <style>
                    .conteudos-toggle .conteudos-toggle-icon {
                        transition: transform .2s ease;
                    }

                    .conteudos-toggle:not(.collapsed) .conteudos-toggle-icon {
                        transform: rotate(180deg);
                    }
                </style>
            </div>
        </div>
    </div>

</x-layout>
