<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Administrativo </span> - Listar Administrativo</h3>
                <a class="btn btn-primary" href="{{ route('administrativo.create') }}">Cadastrar Administrativo</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('administrativo.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="nome">Nome</label>
                            <input class="form-control" type="text" name="nome" id="nome"
                              value="{{ request()->query('nome') }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="escola">Escola</label>
                            <input class="form-control" type="text" name="escola" id="escola"
                              value="{{ request()->query('escola') }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2">

                        <div class="form-group m-0">
                            <label for="cargo">Cargo</label>
                            <input class="form-control" type="text" name="cargo" id="cargo"
                              value="{{ request()->query('cargo') }}">
                        </div>

                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end">

                        <button class="btn btn-primary mr-1">Pesquisar</button>
                        <a href="{{ route('administrativo.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-12 my-3">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Escola</th>
                                <th>Cargo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($administrativos as $key => $administrativo)
                                    <tr>
                                        <td>{{ $administrativo->usuario?->name }}</td>
                                        <td>{{ $administrativo->escola?->razao_social }}</td>
                                        <td>{{ $administrativo->cargo?->titulo }}</td>
                                        <td>
                                            <a href="{{ route('administrativo.show',$administrativo->id)}}"><x-bx-detail width="30"/></a>
                                            <a href="{{ route('administrativo.edit', $administrativo->id)}}"><x-bx-pencil width="30" /></a>
                                        </td>
                                    </tr>

                                @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $administrativos->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
