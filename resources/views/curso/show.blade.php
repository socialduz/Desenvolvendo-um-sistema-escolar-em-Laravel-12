<x-layout>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Curso</span> - Visualizar Curso</h3>
                <a class="btn btn-primary" href="{{ route('curso.index') }}">Listar Cursos</a>
            </div>

            <div class="col-12 col-md-6 col-lg-5 my-5">
                <div class="row">
                    <div class="col-12 col-md-8 my-2">
                        <div class="form-group m-0">
                            <label for="nome">Nome</label>
                            <input id="nome" class="form-control" type="text" value="{{ $curso->nome }}" readonly>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 my-2">
                        <div class="form-group m-0">
                            <label for="status">Status</label>
                            <input id="status" class="form-control" type="text" value="{{ $curso->status == 1 ? 'Ativo' : 'Inativo' }}" readonly>
                        </div>
                    </div>

                    <div class="col-12 col-md-8 my-2">
                        <div class="form-group m-0">
                            <label for="descricao">Descrição</label>
                            <input id="descricao" class="form-control" type="text" value="{{ $curso->descricao }}" readonly>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 my-2">
                        <div class="form-group m-0">
                            <label for="preco">Valor</label>
                            <input id="preco" class="form-control" type="text" value="{{ $curso->preco }}" readonly>
                        </div>
                    </div>

                    <div class="col-12 my-2">
                        <label for="observacao">Observação</label>
                        <textarea id="observacao" class="form-control" cols="30" rows="5" readonly>{{ $curso->observacao }}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layout>
