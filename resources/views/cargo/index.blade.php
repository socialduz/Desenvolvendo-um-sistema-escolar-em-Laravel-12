<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Cargo</span>-Listar Cargos</h3>
                <a class="btn btn-primary" href="{{ route('cargo.create') }}">Cadastrar Cargo</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta" />

                <form method="GET" action="{{ route('cargo.index') }}">
                    <input type="hidden" name="pesquisar" value="1">
                    <div class="row align-items-end mb-3">
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group mb-0">
                                <label for="titulo">Título</label>
                                <input class="form-control" type="text" name="titulo" id="titulo">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group mb-0">
                                <label for="descricao">Descrição</label>
                                <input class="form-control" type="text" name="descricao" id="descricao">
                            </div>
                        </div>

                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group mb-0">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">-</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-2 col-lg-2 d-flex">
                            <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                            <a href="{{ route('cargo.index') }}" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Data de criação</th>
                                        <th>Última alteração</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cargos as $cargo)
                                    <tr>
                                        <td>{{ $cargo->titulo }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($cargo->descricao, 50) }}</td>
                                        <td>{{ (int) $cargo->status === 1 ? 'Ativo' : 'Inativo' }}</td>
                                        <td>{{ $cargo->dt_create ? date('d/m/Y', strtotime($cargo->dt_create)) : '-' }}</td>
                                        <td>{{ $cargo->dt_update ? date('d/m/Y', strtotime($cargo->dt_update)) : '-' }}</td>
                                        <td class="text-nowrap">
                                            @include('cargo._acoes', ['cargo' => $cargo])
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $cargos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
