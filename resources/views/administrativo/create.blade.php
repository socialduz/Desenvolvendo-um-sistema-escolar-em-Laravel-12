<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Administrativo</span> - Cadastrar Administrativo</h3>
                <a class="btn btn-primary" href="{{ route('administrativo.index') }}">Listar Administrativos</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="POST" action="{{ route('administrativo.store') }}">
                    @csrf

                    <div class="row align-items-end">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="id_usuario">Usuário <span class="text-danger">*</span></label>
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

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
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

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label class="d-block" for="id_cargo">Cargo <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_cargo') is-invalid @enderror" name="id_cargo" id="id_cargo">
                                    <option value="">-</option>
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}" @selected(old('id_cargo') == $cargo->id)>
                                            {{ $cargo->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_cargo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 d-flex mb-3">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('administrativo.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
