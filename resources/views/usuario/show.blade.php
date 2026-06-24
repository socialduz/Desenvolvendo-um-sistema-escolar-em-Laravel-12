<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Usuário</span> - Visualizar Usuário</h3>
                <a class="btn btn-primary" href="{{ route('usuario.index') }}">Listar Usuários</a>
            </div>

            <div class="col-12 my-5">
                <div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label class="d-block" for="name">Nome</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    value="{{ $usuario->name }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="rg">RG</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="rg"
                                    value="{{ $usuario->rg }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cpf">CPF</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="cpf"
                                    value="{{ $usuario->cpf }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="status">Status</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="status"
                                    value="{{ (int) $usuario->status === 1 ? 'Ativo' : 'Inativo' }}"
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="telefone">Telefone</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="telefone"
                                    value="{{ $usuario->telefone }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="email">E-mail</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="email"
                                    value="{{ $usuario->email }}"
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
                                    value="{{ $usuario->endereco }}"
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
                                    value="{{ $usuario->complemento }}"
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
                                    value="{{ $usuario->bairro }}"
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
                                    value="{{ $usuario->cidade }}"
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
                                    value="{{ $usuario->estado }}"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="observacao">Observação</label>
                                <p class="form-control-plaintext border rounded mb-0 px-3 py-2 bg-light text-break">{{ $usuario->observacao ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
