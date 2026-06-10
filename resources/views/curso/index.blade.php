<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">      
                <h3 class="my-0"> <span class="font-weight-bold">Curso</span>-Listar Cursos </h3>
                <a class="btn btn-primary" href="{{route('curso.create')}}">Cadastrar Curso</a>
            </div>

            <div class="col-12 my-5">
                <form method="GET" action="{{ route('curso.index') }}">
                <input type="hidden" name="pesquisar" value="1">
                <div class="row">

                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input class="form-control" type="text" name="nome" id="nome">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                            <label for="descricao">Descricao</label>
                            <input class="form-control" type="text" name="descricao" id="descricao">
                        </div>
                    </div>  

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">-</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary mr-1">Pesquisar</button>
                        <a href="{{ route('curso.index') }}" class="btn btn-danger">Limpar</a>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead> 
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Data de cadastro</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cursos as $curso)
                                    <tr>
                                        <td>{{ $curso->nome }}</td>
                                        <td>{{ $curso->descricao }}</td>
                                        <td>{{ date('d/m/Y', strtotime($curso->dt_cadastro)) }}</td>
                                        <td>{{ $curso->status == 1 ? 'Ativo' : 'Inativo' }}</td>
                                        <td>
                                            <a href="{{ route('curso.show', $curso->id) }}"><x-bx-detail width="30" /></a>
                                            <a href="{{ route('curso.edit', $curso->id) }}"><x-bx-pencil width="30" /></a>
                                            <a href=""><x-bx-trash width="30" class="text-danger" /></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end">
                        {{ $cursos->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layout>