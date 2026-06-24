<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Usuário</span> - Editar Usuário</h3>
                <a class="btn btn-primary" href="{{ route('usuario.index') }}">Listar Usuários</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="POST" action="{{ route('usuario.update', $usuario) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <label class="d-block" for="name">Nome <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $usuario->name) }}"
                                    maxlength="255"
                                >
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="rg">RG <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('rg') is-invalid @enderror"
                                    type="text"
                                    name="rg"
                                    id="rg"
                                    value="{{ old('rg', $usuario->rg) }}"
                                    maxlength="20"
                                >
                                @error('rg')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="cpf">CPF <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('cpf') is-invalid @enderror"
                                    type="text"
                                    name="cpf"
                                    id="cpf"
                                    value="{{ old('cpf', $usuario->cpf) }}"
                                    maxlength="20"
                                >
                                @error('cpf')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="1" @selected(old('status', $usuario->status) == 1)>Ativo</option>
                                    <option value="0" @selected(old('status', $usuario->status) == 0)>Inativo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="telefone">Telefone</label>
                                <input
                                    class="form-control @error('telefone') is-invalid @enderror"
                                    type="text"
                                    name="telefone"
                                    id="telefone"
                                    value="{{ old('telefone', $usuario->telefone) }}"
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
                                <label class="d-block" for="email">E-mail <span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $usuario->email) }}"
                                    maxlength="255"
                                >
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="d-block" for="password">Senha</label>
                                <input
                                    class="form-control @error('password') is-invalid @enderror"
                                    type="password"
                                    name="password"
                                    id="password"
                                >
                                @error('password')
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
                                    value="{{ old('endereco', $usuario->endereco) }}"
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
                                    value="{{ old('complemento', $usuario->complemento) }}"
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
                                    value="{{ old('bairro', $usuario->bairro) }}"
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
                                    value="{{ old('cidade', $usuario->cidade) }}"
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
                                    value="{{ old('estado', $usuario->estado) }}"
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
                                >{{ old('observacao', $usuario->observacao) }}</textarea>
                                @error('observacao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('usuario.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
