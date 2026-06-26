<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Usuário </span> - Listar Usuários</h3>
                <a class="btn btn-primary" href="{{ route('usuario.create') }}">Cadastrar Usuário</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('usuario.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">

                        <div class="form-group m-0">
                            <label for="">Cpf</label>
                            <input class="form-control" type="text" name="cpf" 
                              value="{{ request()->query("cpf") }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Rg</label>
                            <input class="form-control" type="text" name="rg" 
                            value="{{ request()->query("rg") }}">
                        </div>

                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Nome</label>
                            <input class="form-control" type="text" name="nome" 
                              value="{{ request()->query("nome") }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2">

                        <div class="form-group m-0">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="">
                                <option value="" @selected(! filled(request()->query('status')))>-</option>
                                <option value="1" @selected(request()->query('status') == 1)>Ativo</option>
                                <option value="0" @selected(request()->query('status') === '0' || request()->query('status') === 0)>Inativo</option>
                            </select>
                        </div>

                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end">

                        <button class="btn btn-primary mr-1">Pesquisar</button>
                        <a href="{{ route('usuario.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-12 my-3">
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
                            @foreach ($usuarios as $key => $usuario)
                                <tr>
                                    <td>{{ $usuario->rg }}</td>
                                    <td>{{ $usuario->cpf }}</td>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->telefone }}</td>
                                    <td>{{ $usuario->status == 1  ? "Ativo" : "Inativo" }}</td>
                                    <td>
                                        <a href="{{ route('usuario.show',$usuario->id)}}"><x-bx-detail width="30"/></a>
                                        <a href="{{ route('usuario.edit', $usuario->id)}}"><x-bx-pencil width="30" /></a>
                                        <a href="{{ route('usuario.cursos', $usuario->id)}}"><x-bx-book width="30" /></a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $usuarios->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
