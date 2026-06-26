@use('App\Models\Curso')

<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Turma</span> - Visualizar Turma</h3>
                <a class="btn btn-primary" href="{{ route('turma.index') }}">Listar Turmas</a>
            </div>

            <div class="col-12 my-5">
                {{-- LINHA 1: professor + escola --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="professor">Professor</label>
                            <input
                                class="form-control"
                                type="text"
                                id="professor"
                                value="{{ $turma->professor?->registro ?? '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="escola">Escola</label>
                            <input
                                class="form-control"
                                type="text"
                                id="escola"
                                value="{{ $turma->escola->razao_social }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 2: código + descrição --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="nome">Código</label>
                            <input
                                class="form-control"
                                type="text"
                                id="nome"
                                value="{{ $turma->nome }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="descricao">Descrição</label>
                            <input
                                class="form-control"
                                type="text"
                                id="descricao"
                                value="{{ $turma->descricao }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 3: datas + status --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="dt_inicio">Data início</label>
                            <input
                                class="form-control"
                                type="text"
                                id="dt_inicio"
                                value="{{ $turma->dt_inicio ? date('d/m/Y', strtotime($turma->dt_inicio)) : '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="dt_termino">Data término</label>
                            <input
                                class="form-control"
                                type="text"
                                id="dt_termino"
                                value="{{ $turma->dt_termino ? date('d/m/Y', strtotime($turma->dt_termino)) : '-' }}"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="status">Status</label>
                            <input
                                class="form-control"
                                type="text"
                                id="status"
                                value="{{ (int) $turma->status === 1 ? 'Ativo' : 'Inativo' }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                {{-- LINHA 4: observação --}}
                <div class="row align-items-end">
                    <div class="col-12 col-lg-8">
                        <div class="form-group my-2 mb-0">
                            <label class="d-block" for="observacao">Observação</label>
                            <textarea
                                class="form-control"
                                id="observacao"
                                rows="3"
                                disabled
                            >{{ $turma->observacao }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold">Cursos vinculados / Alunos</h4>
                    </div>

                    <div class="col-12 my-2">
                        @forelse ($cursosJaVinculados as $curso)
                            <div class="card my-2">
                                <div class="card-body">
                                    <h5 class="my-2"><b>{{ $curso->nome }}</b> — {{ $curso->descricao }}</h5>

                                    @php
                                        $alunos = Curso::getAlunosByCurso($curso->id, $turma->id);
                                    @endphp

                                    <div class="table-responsive my-2">
                                        <table class="table table-striped table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Aluno</th>
                                                    <th>Nota</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($alunos as $aluno)
                                                    <tr>
                                                        <td>{{ $aluno->name }}</td>
                                                        <td>
                                                            @if (Curso::podeEditarCurso($turma->id))
                                                                <form
                                                                    action="{{ route('turma.atualiza-nota', ['id' => $aluno->id]) }}"
                                                                    method="post"
                                                                    class="d-inline-flex align-items-center"
                                                                >
                                                                    @csrf
                                                                    @method('put')
                                                                    <input
                                                                        type="number"
                                                                        name="nota"
                                                                        value="{{ $aluno->nota }}"
                                                                        class="form-control form-control-sm mr-2"
                                                                        style="width: 5rem;"
                                                                    >
                                                                    <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                                                                </form>
                                                            @else
                                                                {{ strlen($aluno->nota) > 0 ? $aluno->nota : 'Não Atribuído' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-muted">Nenhum aluno vinculado a este curso nesta turma.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Nenhum curso vinculado a esta turma.</p>
                        @endforelse
                    </div>
                </div>

                {{-- LINHA 5: Voltar --}}
                <div class="row">
                    <div class="col-12 d-flex my-3">
                        <a href="{{ route('turma.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
