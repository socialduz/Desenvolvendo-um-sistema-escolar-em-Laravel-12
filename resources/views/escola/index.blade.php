<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Escola </span> - Listar Escolas</h3>
                <a class="btn btn-primary" href="{{ route('escola.create') }}">Cadastrar Escola</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('escola.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">

                        <div class="form-group m-0">
                            <label for="">Código</label>
                            <input class="form-control" type="text" name="codigo_escola" 
                              value="{{ request()->query("codigo_escola") }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Nome Fantasia</label>
                            <input class="form-control" type="text" name="nome_fantasia" 
                              value="{{ request()->query("nome_fantasia") }}">
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Razão Social</label>
                            <input class="form-control" type="text" name="razao_social" 
                            value="{{ request()->query("razao_social") }}">
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
                        <a href="{{ route('escola.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-12 my-3">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>CNPJ</th>
                                <th>Nome Fantasia</th>
                                <th>Razão Social</th>
                                <th>Telefone</th>
                                <th>Data de Cadastro</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($escolas as $key => $escola)
                                    <tr>
                                        <td>{{ $escola->codigo_escola }}</td>
                                        <td>{{ $escola->cnpj }}</td>
                                        <td>{{ $escola->nome_fantasia }}</td>
                                        <td>{{ $escola->razao_social }}</td>
                                        <td>{{ $escola->telefone }}</td>
                                        <td>{{ date('d/m/Y', strtotime($escola->data_inauguracao)) }}</td>
                                        <td>{{ $escola->status == 1  ? "Ativo" : "Inativo" }}</td>
                                        <td>
                                            <a href="{{ route('escola.show',$escola->id)}}"><x-bx-detail width="30"/></a>
                                            <a href="{{ route('escola.edit', $escola->id)}}"><x-bx-pencil width="30" /></a>
                                        </td>
                                    </tr>

                                @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $escolas->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
