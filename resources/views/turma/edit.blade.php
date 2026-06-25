<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Cadastrar Turma</h3>
                <a class="btn btn-primary" href="{{ route('turma.index') }}">Listar Turmas</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="POST" action="{{ route('turma.update', $turma) }}">
                    @csrf
                    @method('PUT')
                    {{--
                        Cada campo HTML usa name="..." igual à coluna da tabela turma no banco.
                        O Laravel envia esses names no POST quando você clica em Salvar.

                        ┌──────────────────────────────────────────────────────────────┐
                        │ LINHA 1  │ Professor(6)  │ Escola(6)                        │
                        │ LINHA 2  │ Código(6)     │ Descrição(6)                     │
                        │ LINHA 3  │ Início(4)     │ Término(4)   │ Status(4)         │
                        │ LINHA 4  │ Observação(8)                                  │
                        │ LINHA 5  │ Botões Salvar / Cancelar                       │
                        └──────────────────────────────────────────────────────────────┘
                    --}}

                    {{-- LINHA 1: id_professor + id_escola --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-6">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="id_professor">Professor</label>
                                <select class="form-control @error('id_professor') is-invalid @enderror" name="id_professor" id="id_professor">
                                    <option value="">-</option>
                                    @foreach ($professores as $professor)
                                        <option value="{{ $professor->id }}" @selected(old('id_professor', $turma->id_professor) == $professor->id)>
                                            {{ $professor->registro }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_professor')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="id_escola">Escola <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_escola') is-invalid @enderror" name="id_escola" id="id_escola">
                                    <option value="">-</option>
                                    @foreach ($escolas as $escola)
                                        <option value="{{ $escola->id }}" @selected(old('id_escola', $turma->id_escola) == $escola->id)>
                                            {{ $escola->razao_social }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_escola')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 2: nome (código) + descricao --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-6">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="nome">Código <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('nome') is-invalid @enderror"
                                    type="text"
                                    name="nome"
                                    id="nome"
                                    value="{{ old('nome', $turma->nome) }}"
                                >
                                @error('nome')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="descricao">Descrição <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    type="text"
                                    name="descricao"
                                    id="descricao"
                                    value="{{ old('descricao', $turma->descricao) }}"
                                >
                                @error('descricao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 3: dt_inicio + dt_termino + status --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="dt_inicio">Data início <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('dt_inicio') is-invalid @enderror"
                                    type="date"
                                    name="dt_inicio"
                                    id="dt_inicio"
                                    value="{{ old('dt_inicio', $turma->dt_inicio) }}"
                                >
                                @error('dt_inicio')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="dt_termino">Data término <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('dt_termino') is-invalid @enderror"
                                    type="date"
                                    name="dt_termino"
                                    id="dt_termino"
                                    value="{{ old('dt_termino', $turma->dt_termino) }}"
                                >
                                @error('dt_termino')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="1" @selected(old('status', $turma->status) == 1)>Ativo</option>
                                    <option value="0" @selected(old('status', $turma->status) == 0)>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 4: observacao --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-8">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="observacao">Observação</label>
                                <textarea
                                    class="form-control @error('observacao') is-invalid @enderror"
                                    name="observacao"
                                    id="observacao"
                                    rows="3"
                                >{{ old('observacao', $turma->observacao) }}</textarea>
                                @error('observacao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 5: Botões --}}
                    <div class="row">
                        <div class="col-12 d-flex my-3">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('turma.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
