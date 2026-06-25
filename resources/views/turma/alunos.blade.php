<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Gestão de Alunos</h3>
                <a class="btn btn-primary" href="{{ route('turma.index') }}">Listar Turmas</a>
            </div>

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                <div class="border-left-info bg-light rounded py-2 px-3 mb-4 small">
                    <span class="font-weight-bold text-info">Turma selecionada</span>
                    <p class="mb-0 mt-1 text-muted">{{ $turma->nome }}</p>
                </div>

                <form method="POST" action="{{ route('turma.ad-alunos') }}">
                    @csrf
                    <input type="hidden" name="id_turma" value="{{ $turma->id }}">

                    <p class="font-weight-bold mb-3">Alunos ativos</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;"></th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alunos as $aluno)
                                    <tr>
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="aluno[]"
                                                value="{{ $aluno->id }}"
                                                @checked(in_array($aluno->id, $alunosAdicionados))
                                            >
                                        </td>
                                        <td>{{ $aluno->name }}</td>
                                        <td>{{ $aluno->cpf }}</td>
                                        <td>{{ $aluno->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">Nenhum aluno ativo cadastrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('turma.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar alunos</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
