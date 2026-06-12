<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Tipo de Conteúdo</span>-Listar Tipos</h3>
                <a class="btn btn-primary" href="{{ route('tipo-conteudo.create') }}">Cadastrar Tipo</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta" />

                <form method="GET" action="{{ route('tipo-conteudo.index') }}">
                    <input type="hidden" name="pesquisar" value="1">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <input class="form-control" type="text" name="tipo" id="tipo">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">-</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                            <a href="{{ route('tipo-conteudo.index') }}" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Data de criação</th>
                                        <th>Última alteração</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipos as $tipoConteudo)
                                    <tr>
                                        <td>{{ $tipoConteudo->tipo }}</td>
                                        <td>{{ (int) $tipoConteudo->status === 1 ? 'Ativo' : 'Inativo' }}</td>
                                        <td>{{ $tipoConteudo->dt_create ? date('d/m/Y', strtotime($tipoConteudo->dt_create)) : '-' }}</td>
                                        <td>{{ $tipoConteudo->dt_update ? date('d/m/Y', strtotime($tipoConteudo->dt_update)) : '-' }}</td>
                                        <td class="text-nowrap">
                                            @include('tipo-conteudo._acoes', ['tipoConteudo' => $tipoConteudo])
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $tipos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
