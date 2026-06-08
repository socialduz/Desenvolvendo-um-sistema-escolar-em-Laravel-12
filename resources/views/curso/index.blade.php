<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">      
                <h3 class="my-0"> <span class="font-weight-bold">Curso</span>-Listar Cursos </h3>
                <a class="btn btn-primary" href="{{route('curso.create')}}">Cadastrar Curso</a>
            </div>

            <div class="col-12 my-5">
                <div class="row">

                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                            <label for="">Nome</label>
                            <input class="form-control" type="text" name="Curso[nome]">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                            <label for="">Descricao</label>
                            <input class="form-control" type="text" name="Curso[descricao]">
                        </div>
                    </div>  

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="" id="">
                                <option value="">-</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 col-xl-2 col-xxl-2 d-flex align-items-end mb-3">
                        <button class="btn btn-primary mr-1">Pesquisar</button>
                        <button class="btn btn-danger">Limpar</button>
                    </div> <div class="col-12 mt-4">
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
                                    <tr>
                                        <td>Curso de Matemática</td>
                                        <td>Curso de Matemática para iniciantes</td>
                                        <td>05/06/2026</td>
                                        <td>Ativo</td>
                                        <td>
                                           <a href=""><x-bx-detail width="30" /></a>
                                            <button class="btn btn-warning">Editar</button>
                                            <button class="btn btn-danger">Deletar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-layout>