<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Listar Turmas</h3>
                <a class="btn btn-primary" href="{{ route('turma.create') }}">Cadastrar Turma</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="GET" action="{{ route('turma.index') }}">
                    <input type="hidden" name="pesquisar" value="1">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="nome">Código</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    name="nome"
                                    id="nome"
                                    value="{{ request('nome') }}"
                                >
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="id_escola">Escola</label>
                                <select class="form-control" name="id_escola" id="id_escola">
                                    <option value="">-</option>
                                    @foreach ($escolas as $escola)
                                        <option value="{{ $escola->id }}" @selected(request('id_escola') == $escola->id)>
                                            {{ $escola->razao_social }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="id_professor">Professor</label>
                                <select class="form-control" name="id_professor" id="id_professor">
                                    <option value="">-</option>
                                    @foreach ($professores as $professor)
                                        <option value="{{ $professor->id }}" @selected(request('id_professor') == $professor->id)>
                                            {{ $professor->usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                            <a href="{{ route('turma.index') }}" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Escola</th>
                                        <th>Professor</th>
                                        <th>Início</th>
                                        <th>Término</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($turmas as $turma)
                                        <tr>
                                            <td>{{ $turma->nome }}</td>
                                            <td>{{ $turma->escola->razao_social }}</td>
                                            <td>{{ $turma->professor?->usuario?->name ?? '-' }}</td>
                                            <td>{{ $turma->dt_inicio ? date('d/m/Y', strtotime($turma->dt_inicio)) : '-' }}</td>
                                            <td>{{ $turma->dt_termino ? date('d/m/Y', strtotime($turma->dt_termino)) : '-' }}</td>
                                            <td class="text-nowrap">
                                                @include('turma._acoes', ['turma' => $turma])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $turmas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
