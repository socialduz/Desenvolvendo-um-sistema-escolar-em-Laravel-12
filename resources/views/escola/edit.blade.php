<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Escola</span>-Editar Escola</h3>
                <a class="btn btn-primary" href="{{ route('escola.index') }}">Listar Escolas</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="POST" action="{{ route('escola.update', $escola) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="codigo_escola">Código <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('codigo_escola') is-invalid @enderror"
                                    type="text"
                                    name="codigo_escola"
                                    id="codigo_escola"
                                    value="{{ old('codigo_escola', $escola->codigo_escola) }}"
                                    maxlength="20"
                                >
                                @error('codigo_escola')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cnpj">CNPJ <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('cnpj') is-invalid @enderror"
                                    type="text"
                                    name="cnpj"
                                    id="cnpj"
                                    value="{{ old('cnpj', $escola->cnpj) }}"
                                    maxlength="20"
                                >
                                @error('cnpj')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="data_inauguracao">Data de inauguração <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('data_inauguracao') is-invalid @enderror"
                                    type="date"
                                    name="data_inauguracao"
                                    id="data_inauguracao"
                                    value="{{ old('data_inauguracao', $escola->data_inauguracao) }}"
                                >
                                @error('data_inauguracao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="1" @selected(old('status', $escola->status) == 1)>Ativo</option>
                                    <option value="0" @selected(old('status', $escola->status) == 0)>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group mb-0">
                                <label class="d-block" for="nome_fantasia">Nome Fantasia <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('nome_fantasia') is-invalid @enderror"
                                    type="text"
                                    name="nome_fantasia"
                                    id="nome_fantasia"
                                    value="{{ old('nome_fantasia', $escola->nome_fantasia) }}"
                                    maxlength="200"
                                >
                                @error('nome_fantasia')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="razao_social">Razão Social <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('razao_social') is-invalid @enderror"
                                    type="text"
                                    name="razao_social"
                                    id="razao_social"
                                    value="{{ old('razao_social', $escola->razao_social) }}"
                                    maxlength="200"
                                >
                                @error('razao_social')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="telefone">Telefone</label>
                                <input
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    type="text"
                                    name="telefone"
                                    id="telefone"
                                    value="{{ old('telefone', $escola->telefone) }}"
                                    maxlength="20"
                                >
                                @error('telefone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="endereco">Endereço <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('endereco') is-invalid @enderror"
                                    type="text"
                                    name="endereco"
                                    id="endereco"
                                    value="{{ old('endereco', $escola->endereco) }}"
                                >
                                @error('endereco')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="complemento">Complemento</label>
                                <input
                                    class="form-control @error('complemento') is-invalid @enderror"
                                    type="text"
                                    name="complemento"
                                    id="complemento"
                                    value="{{ old('complemento', $escola->complemento) }}"
                                >
                                @error('complemento')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="bairro">Bairro <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('bairro') is-invalid @enderror"
                                    type="text"
                                    name="bairro"
                                    id="bairro"
                                    value="{{ old('bairro', $escola->bairro) }}"
                                    maxlength="100"
                                >
                                @error('bairro')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cidade">Cidade <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('cidade') is-invalid @enderror"
                                    type="text"
                                    name="cidade"
                                    id="cidade"
                                    value="{{ old('cidade', $escola->cidade) }}"
                                    maxlength="100"
                                >
                                @error('cidade')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="estado">Estado <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('estado') is-invalid @enderror"
                                    type="text"
                                    name="estado"
                                    id="estado"
                                    value="{{ old('estado', $escola->estado) }}"
                                    maxlength="100"
                                >
                                @error('estado')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="observacao">Observação</label>
                                <textarea
                                    class="form-control @error('observacao') is-invalid @enderror"
                                    name="observacao"
                                    id="observacao"
                                    rows="3"
                                >{{ old('observacao', $escola->observacao) }}</textarea>
                                @error('observacao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('escola.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
