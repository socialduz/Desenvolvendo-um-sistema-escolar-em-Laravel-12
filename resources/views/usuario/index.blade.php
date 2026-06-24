<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Usuário</span> - Listar Usuários</h3>
                <a class="btn btn-primary" href="{{ route('usuario.create') }}">Cadastrar Usuário</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="GET" action="{{ route('usuario.index') }}">
                    <input type="hidden" name="pesquisar" value="1">
                    <div class="row">

                        <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input class="form-control" type="text" name="cpf" id="cpf"
                                    value="{{ request('cpf') }}">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="rg">RG</label>
                                <input class="form-control" type="text" name="rg" id="rg"
                                    value="{{ request('rg') }}">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ request('name') }}">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">-</option>
                                    <option value="1" @selected(request('status') === '1')>Ativo</option>
                                    <option value="0" @selected(request('status') === '0')>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                            <a href="{{ route('usuario.index') }}" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>RG</th>
                                        <th>CPF</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->rg }}</td>
                                            <td>{{ $usuario->cpf }}</td>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->telefone }}</td>
                                            <td>{{ $usuario->status == 1 ? 'Ativo' : 'Inativo' }}</td>
                                            <td class="text-nowrap">
                                                @include('usuario._acoes', ['usuario' => $usuario])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layout>
