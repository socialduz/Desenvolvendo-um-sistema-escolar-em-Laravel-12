<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Escola</span>-Visualizar Escola</h3>
                <a class="btn btn-primary" href="{{ route('escola.index') }}">Listar Escolas</a>
            </div>

            <div class="col-12 my-5">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="codigo_escola">Código</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="codigo_escola"
                                    value="{{ $escola->codigo_escola }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cnpj">CNPJ</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="cnpj"
                                    value="{{ $escola->cnpj }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="data_inauguracao">Data de inauguração</label>
                                <input
                                    class="form-control"
                                    type="date"
                                    id="data_inauguracao"
                                    value="{{ $escola->data_inauguracao }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="status">Status</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="status"
                                    value="{{ (int) $escola->status === 1 ? 'Ativo' : 'Inativo' }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group mb-0">
                                <label class="d-block" for="nome_fantasia">Nome Fantasia</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="nome_fantasia"
                                    value="{{ $escola->nome_fantasia }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="razao_social">Razão Social</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="razao_social"
                                    value="{{ $escola->razao_social }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="telefone">Telefone</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="telefone"
                                    value="{{ $escola->telefone }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="endereco">Endereço</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="endereco"
                                    value="{{ $escola->endereco }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="complemento">Complemento</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="complemento"
                                    value="{{ $escola->complemento }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="bairro">Bairro</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="bairro"
                                    value="{{ $escola->bairro }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cidade">Cidade</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="cidade"
                                    value="{{ $escola->cidade }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="form-group mb-0">
                                <label class="d-block" for="estado">Estado</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="estado"
                                    value="{{ $escola->estado }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="observacao">Observação</label>
                                <p class="form-control-plaintext border rounded mb-0 px-3 py-2 bg-light text-break">{{ $escola->observacao ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</x-layout>
