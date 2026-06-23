<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">      
                <h3 class="my-0"> <span class="font-weight-bold">Escola</span>-Listar Escolas </h3>
                <a class="btn btn-primary" href="{{ route('escola.create') }}">Cadastrar Escola</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <form method="GET" action="{{ route('escola.index') }}">
                <input type="hidden" name="pesquisar" value="1">
                <div class="row">

<div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
    <div class="form-group">
        <label for="codigo_escola">Código</label>
        <input class="form-control" type="text" name="codigo_escola" id="codigo_escola"
            value="{{ request('codigo_escola') }}">
    </div>
</div>

<div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
    <div class="form-group">
        <label for="nome_fantasia">Nome Fantasia</label>
        <input class="form-control" type="text" name="nome_fantasia" id="nome_fantasia"
            value="{{ request('nome_fantasia') }}">
    </div>
</div>

<div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
    <div class="form-group">
        <label for="razao_social">Razão Social</label>
        <input class="form-control" type="text" name="razao_social" id="razao_social"
            value="{{ request('razao_social') }}">
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
    <a href="{{ route('escola.index') }}" class="btn btn-danger">Limpar</a>
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
                                        <th>Nome Fantasia</th>
                                        <th>Razão Social</th>
                                        <th>CNPJ</th>
                                        <th>Telefone</th>
                                        <th>Data de inauguração</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($escolas as $escola)
                                    <tr>
                                        <td>{{ $escola->codigo_escola }}</td>
                                        <td>{{ $escola->nome_fantasia }}</td>
                                        <td>{{ $escola->razao_social }}</td>
                                        <td>{{ $escola->cnpj }}</td>
                                        <td>{{ $escola->telefone }}</td>
                                        <td>{{ date('d/m/Y', strtotime($escola->data_inauguracao)) }}</td>
                                        <td>{{ $escola->status == 1 ? 'Ativo' : 'Inativo' }}</td>
                                        <td class="text-nowrap">
                                            @include('escola._acoes', ['escola' => $escola])
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $escolas->links() }}
                    </div>                </div>
            </div>

        </div>
    </div>

</x-layout>