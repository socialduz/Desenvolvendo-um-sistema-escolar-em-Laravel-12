<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Administrativo</span> - Visualizar Administrativo</h3>
                <a class="btn btn-primary" href="{{ route('administrativo.index') }}">Listar Administrativos</a>
            </div>

            <div class="col-12 my-5">
                <div class="row mb-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group mb-0">
                            <label class="d-block" for="id_usuario">Usuário</label>
                            <input
                                class="form-control"
                                type="text"
                                id="id_usuario"
                                value="{{ $administrativo->usuario->name }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group mb-0">
                            <label class="d-block" for="id_escola">Escola</label>
                            <input
                                class="form-control"
                                type="text"
                                id="id_escola"
                                value="{{ $administrativo->escola->razao_social }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group mb-0">
                            <label class="d-block" for="id_cargo">Cargo</label>
                            <input
                                class="form-control"
                                type="text"
                                id="id_cargo"
                                value="{{ $administrativo->cargo->titulo }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
