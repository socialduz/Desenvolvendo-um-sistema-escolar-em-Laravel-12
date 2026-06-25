<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Visualizar Turma</h3>
                <a class="btn btn-primary" href="{{ route('turma.index') }}">Listar Turmas</a>
            </div>

            <div class="col-12 my-5">
                {{-- LINHA 1: professor + escola --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="professor">Professor</label>
                            <input
                                class="form-control"
                                type="text"
                                id="professor"
                                value="{{ $turma->professor?->registro ?? '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="escola">Escola</label>
                            <input
                                class="form-control"
                                type="text"
                                id="escola"
                                value="{{ $turma->escola->razao_social }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 2: código + descrição --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="nome">Código</label>
                            <input
                                class="form-control"
                                type="text"
                                id="nome"
                                value="{{ $turma->nome }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="descricao">Descrição</label>
                            <input
                                class="form-control"
                                type="text"
                                id="descricao"
                                value="{{ $turma->descricao }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 3: datas + status --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="dt_inicio">Data início</label>
                            <input
                                class="form-control"
                                type="text"
                                id="dt_inicio"
                                value="{{ $turma->dt_inicio ? date('d/m/Y', strtotime($turma->dt_inicio)) : '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="dt_termino">Data término</label>
                            <input
                                class="form-control"
                                type="text"
                                id="dt_termino"
                                value="{{ $turma->dt_termino ? date('d/m/Y', strtotime($turma->dt_termino)) : '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="status">Status</label>
                            <input
                                class="form-control"
                                type="text"
                                id="status"
                                value="{{ (int) $turma->status === 1 ? 'Ativo' : 'Inativo' }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 4: observação --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-8">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="observacao">Observação</label>
                            <textarea
                                class="form-control"
                                id="observacao"
                                rows="3"
                                disabled
                            >{{ $turma->observacao }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- LINHA 5: Voltar --}}
                <div class="row">
                    <div class="col-12 d-flex my-3">
                        <a href="{{ route('turma.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
