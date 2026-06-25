<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Professor</span> - Visualizar Professor</h3>
                <a class="btn btn-primary" href="{{ route('professor.index') }}">Listar Professores</a>
            </div>

            <div class="col-12 my-5">
                <div class="row align-items-end">
                    <div class="col-12 col-lg-3">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="registro">Registro</label>
                            <input class="form-control" type="text" id="registro" value="{{ $professor->registro }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="professor">Professor</label>
                            <input class="form-control" type="text" id="professor" value="{{ $professor->usuario->name }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="escola">Escola</label>
                            <input class="form-control" type="text" id="escola" value="{{ $professor->escola->razao_social }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="status">Status</label>
                            <input
                                class="form-control"
                                type="text"
                                id="status"
                                value="{{ (int) $professor->status === 1 ? 'Ativo' : 'Inativo' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="salario">Salário</label>
                            <input class="form-control" type="text" id="salario" value="{{ $professor->salario }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="telefone">Telefone</label>
                            <input class="form-control" type="text" id="telefone" value="{{ $professor->telefone }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="data_cadastro">Data cadastro</label>
                            <input
                                class="form-control"
                                type="text"
                                id="data_cadastro"
                                value="{{ date('d/m/Y', strtotime($professor->data_cadastro)) }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="observacao">Observação</label>
                            <p class="form-control-plaintext border rounded mb-0 px-3 py-2 bg-light text-break">{{ $professor->observacao ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
