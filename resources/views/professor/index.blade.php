<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between 
                        align-items-end border-bottom border-secondary py-3">

                <h3 class="my-0"> <span class="font-weight-bold"> Professor </span> - Listar Professores</h3>
                <a class="btn btn-primary" href="{{ route('professor.create') }}">Cadastrar Professor</a>

            </div>

            @include('components.pesquisa-alertas')

            <div class="col-12 my-3">

                <form class="row" action="{{ route('professor.index') }}" method="get">

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Professor</label>
                            <select class="form-control" name="id_usuario" id="id_usuario">
                                <option value="">-</option>
                                @foreach($usuarios as $user)
                                    <option value="{{$user->id}}" 
                                            @selected( request()->query("id_usuario")  == $user->id)>{{ $user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">

                        <div class="form-group m-0">
                            <label for="">Escola</label>
                            <select class="form-control" name="id_escola" id="id_escola">
                                <option value="">-</option>
                                @foreach($escolas as $escola)
                                    <option value="{{$escola->id}}" 
                                            @selected( request()->query("id_escola") == $escola->id)>{{ $escola->razao_social}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-12 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end">

                        <button class="btn btn-primary mr-1">Pesquisar</button>
                        <a href="{{ route('professor.index') }}" class="btn btn-danger">Limpar</a>

                    </div>

                </form>

            </div>

            <div class="col-8 my-3">
                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Registro</th>
                                <th>Professor</th>
                                <th>Escola</th>
                                <th>Data de Cadastro</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($professores as $key => $professor)
                                    <tr>
                                        <td>{{ $professor->registro }}</td>
                                        <td>{{ $professor->usuario->name }}</td>
                                        <td>{{ $professor->escola->razao_social }}</td>
                                        <td>{{ date('d/m/Y', strtotime($professor->data_cadastro)) }}</td>
                                        <td>{{ $professor->status == 1 ? "Ativo" : "Inativo" }}</td>
                                        <td>
                                            <a href="{{ route('professor.show',$professor->id)}}"><x-bx-detail width="30"/></a>
                                            <a href="{{ route('professor.edit', $professor->id)}}"><x-bx-pencil width="30" /></a>
                                        </td>
                                    </tr>

                                @endforeach
                        </tbody>

                    </table>

                </div>

                <div>
                    {{ $professores->links() }}
                </div>

            </div>

        </div>
    </div>

</x-layout>
