<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Tipo de Conteúdo </span> - Listar Tipo de Conteúdo</h3>
                <a class="btn btn-primary" href="{{ route('tipo-conteudo.create') }}">Cadastrar Tipo de Conteúdo</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('tipo-conteudo.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Tipo</label>
                            <input class="form-control" type="text" name="tipo" 
                              value="{{ request()->query("tipo") }}">
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
                        <a href="{{ route('tipo-conteudo.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-7 my-3">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($tipos as $key => $tipo)
                                    <tr>
                                        <td>{{ $tipo->tipo }}</td>
                                        <td>{{ $tipo->status == 1  ? "Ativo" : "Inativo" }}</td>
                                        <td>
                                            <a href="{{ route('tipo-conteudo.show',$tipo->id)}}"><x-bx-detail width="30"/></a>
                                            <a href="{{ route('tipo-conteudo.edit', $tipo->id)}}"><x-bx-pencil width="30" /></a>
                                        </td>
                                    </tr>

                                @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $tipos->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
