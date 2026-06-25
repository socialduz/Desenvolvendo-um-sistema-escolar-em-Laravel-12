<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Professor</span> - Cadastrar Professor</h3>
                <a class="btn btn-primary" href="{{ route('professor.index') }}">Listar Professores</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="POST" action="{{ route('professor.store') }}">
                    @csrf

                    {{--
                        GRID BOOTSTRAP: cada linha é um <div class="row">.
                        As colunas dentro da linha devem somar 12 (ex.: 3+4+5 = 12).

                        ┌─────────────────────────────────────────────────────────┐
                        │ LINHA 1  │ Registro(3) │ Professor(4) │ Escola(5)      │
                        │ LINHA 2  │ Status(4)   │ Salário(4)   │ Telefone(4)    │
                        │ LINHA 3  │ Data(4)     │ Observação(8)                │
                        │ LINHA 4  │ Botões Salvar / Cancelar                    │
                        └─────────────────────────────────────────────────────────┘
                    --}}

                    {{-- LINHA 1: Registro (3) + Professor (4) + Escola (5) = 12 --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-3">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="registro">Registro <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('registro') is-invalid @enderror"
                                    type="text"
                                    name="registro"
                                    id="registro"
                                    value="{{ old('registro') }}"
                                >
                                @error('registro')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="id_usuario">Professor <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_usuario') is-invalid @enderror" name="id_usuario" id="id_usuario">
                                    <option value="">-</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" @selected(old('id_usuario') == $usuario->id)>
                                            {{ $usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_usuario')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="id_escola">Escola <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_escola') is-invalid @enderror" name="id_escola" id="id_escola">
                                    <option value="">-</option>
                                    @foreach ($escolas as $escola)
                                        <option value="{{ $escola->id }}" @selected(old('id_escola') == $escola->id)>
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

                    {{-- LINHA 2: Status (4) + Salário (4) + Telefone (4) = 12 --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="1" @selected(old('status', '1') == '1')>Ativo</option>
                                    <option value="0" @selected(old('status') == '0')>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="salario">Salário <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('salario') is-invalid @enderror"
                                    type="text"
                                    name="salario"
                                    id="salario"
                                    value="{{ old('salario') }}"
                                >
                                @error('salario')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="telefone">Telefone</label>
                                <input
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    type="text"
                                    name="telefone"
                                    id="telefone"
                                    value="{{ old('telefone') }}"
                                >
                                @error('telefone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 3: Data cadastro (4) + Observação (8) = 12 --}}
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-4">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="data_cadastro">Data cadastro <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('data_cadastro') is-invalid @enderror"
                                    type="date"
                                    name="data_cadastro"
                                    id="data_cadastro"
                                    value="{{ old('data_cadastro') }}"
                                >
                                @error('data_cadastro')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="form-group my-2 mb-0">
                                <label class="d-block" for="observacao">Observação</label>
                                <textarea
                                    class="form-control @error('observacao') is-invalid @enderror"
                                    name="observacao"
                                    id="observacao"
                                    rows="3"
                                >{{ old('observacao') }}</textarea>
                                @error('observacao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- LINHA 4: Botões (fora do grid de colunas — ocupa a linha inteira) --}}
                    <div class="row">
                        <div class="col-12 d-flex my-2">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('professor.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
