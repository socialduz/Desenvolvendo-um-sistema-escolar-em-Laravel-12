<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Gestão de Cursos</h3>
                <a class="btn btn-primary" href="{{ route('turma.index') }}">Listar Turmas</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <div class="border-left-info bg-light rounded py-2 px-3 mb-4 small">
                    <span class="font-weight-bold text-info">Turma selecionada</span>
                    <p class="mb-0 mt-1 text-muted">{{ $turma->nome }}</p>
                </div>

                <form method="POST" action="{{ route('turma.ad-cursos') }}">
                    @csrf
                    <input type="hidden" name="id_turma" value="{{ $turma->id }}">

                    <p class="font-weight-bold mb-3">Cursos ativos</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;"></th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cursos as $curso)
                                    <tr>
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="curso[]"
                                                value="{{ $curso->id }}"
                                                @checked(in_array($curso->id, $cursosAdicionados))
                                            >
                                        </td>
                                        <td>{{ $curso->nome }}</td>
                                        <td>{{ $curso->descricao }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted">Nenhum curso ativo cadastrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('turma.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar cursos</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
