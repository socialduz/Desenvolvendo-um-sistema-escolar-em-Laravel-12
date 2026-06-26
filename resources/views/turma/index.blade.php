<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Turma </span> - Listar Turmas</h3>
                <a class="btn btn-primary" href="{{ route('turma.create') }}">Cadastrar Turma</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('turma.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Escola</label>
                            <select class="form-control" name="id_escola" id="id_escola">
                                <option value="">-</option>
                                @foreach($escolas as $escola)
                                    <option value="{{$escola->id}}" 
                                            @selected(request()->query('id_escola') == $escola->id)>{{ $escola->razao_social}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2">

                        <div class="form-group m-0">
                            <label for="">Professor</label>
                            <select class="form-control" name="id_professor" id="id_professor">
                                <option value="">-</option>
                                @foreach($professores as $professor)
                                    <option value="{{$professor->id}}" 
                                            @selected(request()->query('id_professor') == $professor->id)>{{ $professor->registro}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                     <div class="col-12 col-lg-2 col-xl-2 col-xxl-2">
                        <div class="form-group m-0">
                            <label for="">Código</label>
                            <input class="form-control" type="text" name="nome" id="" value="{{ request()->query('nome') }}">
                        </div>
                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end">

                        <button class="btn btn-primary mr-1">Pesquisar</button>
                        <a href="{{ route('turma.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-12 my-3">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Escola</th>
                                <th>Professor</th>
                                <th>Início</th>
                                <th>Término</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($turmas as $key => $turma)
                                    <tr>
                                        <td>{{ $turma->nome }}</td>
                                        <td>{{ $turma->escola?->razao_social ?? '-' }}</td>
                                        <td>{{ $turma->professor?->registro ?? '-' }}</td>
                                        <td>{{ date('d/m/Y', strtotime($turma->dt_inicio)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($turma->dt_termino))}}</td>
                                        <td>{{ $turma->status == 1 ? "Ativo" : "Inativo" }}</td>
                                        <td>
                                            <a href="{{ route('turma.show',$turma->id)}}"><x-bx-detail width="30"/></a>
                                            <a href="{{ route('turma.edit', $turma->id)}}"><x-bx-pencil width="30" /></a>
                                            <a href="{{ route('turma.cursos', $turma->id)}}"><x-bx-book width="30" /></a>
                                            <a href="{{ route('turma.alunos', $turma->id)}}"><x-bx-user width="30" /></a>
                                        </td>
                                    </tr>

                                @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $turmas->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
