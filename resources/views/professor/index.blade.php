<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Professor</span> - Listar Professores</h3>
                <a class="btn btn-primary" href="{{ route('professor.create') }}">Cadastrar Professor</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="GET" action="{{ route('professor.index') }}">
                    <input type="hidden" name="pesquisar" value="1">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="id_usuario">Professor</label>
                                <select class="form-control" name="id_usuario" id="id_usuario">
                                    <option value="">-</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" @selected(request('id_usuario') == $usuario->id)>
                                            {{ $usuario->name }}
                                        </option>
                                    @endforeach
                                </select>
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

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                            <a href="{{ route('professor.index') }}" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Professor</th>
                                        <th>Escola</th>
                                        <th>Registro</th>
                                        <th>Data cadastro</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professores as $professor)
                                        <tr>
                                            <td>{{ $professor->usuario->name }}</td>
                                            <td>{{ $professor->escola->razao_social }}</td>
                                            <td>{{ $professor->registro }}</td>
                                            <td>{{ date('d/m/Y', strtotime($professor->data_cadastro)) }}</td>
                                            <td>{{ (int) $professor->status === 1 ? 'Ativo' : 'Inativo' }}</td>
                                            <td class="text-nowrap">
                                                @include('professor._acoes', ['professor' => $professor])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $professores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
