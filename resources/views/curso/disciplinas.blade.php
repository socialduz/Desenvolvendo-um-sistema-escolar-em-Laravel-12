<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Curso</span>-Gestão de Disciplinas</h3>
                <a class="btn btn-primary" href="{{ route('curso.index') }}">Listar Cursos</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <div class="border-left-info bg-light rounded py-2 px-3 mb-4 small">
                    <span class="font-weight-bold text-info">Curso selecionado</span>
                    <p class="mb-0 mt-1 text-muted">{{ $curso->nome }}</p>
                </div>

                <form method="POST" action="{{ route('curso.add-disciplinas') }}">
                    @csrf
                    <input type="hidden" name="id_curso" value="{{ $curso->id }}">

                    @foreach ($disciplinas as $disciplina)
                        <div class="col-12">
                            <input
                                type="checkbox"
                                name="disciplina[]"
                                value="{{ $disciplina->id }}"
                                @checked(in_array($disciplina->id, $arrayDisciplinas))
                            >
                            <span>{{ $disciplina->nome }}</span>
                        </div>
                    @endforeach

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('curso.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
