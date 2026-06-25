<?php

namespace App\Http\Controllers;

use App\Http\Requests\TurmaRequest;
use App\Models\Curso;
use App\Models\Escola;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\TurmaCurso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;
use App\Models\Aluno;
use App\Models\AlunoTurma;
use App\Models\User;
use App\Models\AlunoCurso;
use App\Models\AlunoDisciplina;
use App\Models\CursoDisciplina;


class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
{
    $query = Turma::query()
        ->with(['escola', 'professor.usuario'])
        ->orderBy('id');

    $hasFilters = $request->filled('nome')
        || $request->filled('id_escola')
        || $request->filled('id_professor');

    if ($request->filled('pesquisar') && $hasFilters) {
        $query->whereLikeInsensitive('nome', $request->query('nome'))
            ->when(
                $request->filled('id_escola'),
                fn ($builder) => $builder->where('id_escola', (int) $request->query('id_escola'))
            )->when(
                $request->filled('id_professor'),
                fn ($builder) => $builder->where('id_professor', (int) $request->query('id_professor'))
            );
    }

    $turmas = $query->paginate(6)->withQueryString();

    $alerta = session('alerta');

    if ($request->filled('pesquisar') && $hasFilters && $turmas->total() === 0) {
        $alerta = [
            'tipo' => 'warning',
            'mensagem' => 'Turma não encontrada',
        ];
    }

    return view('turma.index', [
        'turmas' => $turmas,
        'escolas' => Escola::query()->orderBy('razao_social')->get(),
        'professores' => Professor::query()->with('usuario')->orderBy('id')->get(),
        'alerta' => $alerta,
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{
    return view('turma.create', [
        'escolas' => Escola::query()->orderBy('razao_social')->get(),
        'professores' => Professor::query()->with('usuario')->orderBy('id')->get(),
        'alerta' => session('alerta'),
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(TurmaRequest $request): RedirectResponse
    {
        try {
            Turma::create([
                'id_escola' => $request->id_escola,
                'id_professor' => $request->filled('id_professor') ? $request->id_professor : null,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'dt_inicio' => $request->dt_inicio,
                'dt_termino' => $request->dt_termino,
                'status' => $request->status ?? 1,
                'observacao' => $request->observacao,
            ]);

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Turma cadastrada com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('turma.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar a turma. Tente novamente.',
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma): View
    {
        return view('turma.show', [
            'turma' => $turma->load(['escola', 'professor']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma): View
{
    return view('turma.edit', [
        'turma' => $turma,
        'escolas' => Escola::query()->orderBy('razao_social')->get(),
        'professores' => Professor::query()->with('usuario')->orderBy('id')->get(),
        'alerta' => session('alerta'),
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(TurmaRequest $request, Turma $turma): RedirectResponse
{
    try {
        $turma->update([
            'id_escola' => $request->id_escola,
            'id_professor' => $request->filled('id_professor') ? $request->id_professor : null,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'dt_inicio' => $request->dt_inicio,
            'dt_termino' => $request->dt_termino,
            'status' => $request->status ?? 1,
            'observacao' => $request->observacao,
        ]);

        return redirect()
            ->route('turma.index')
            ->with('alerta', [
                'tipo' => 'success',
                'mensagem' => 'Turma atualizada com sucesso.',
            ]);
    } catch (Throwable) {
        return redirect()
            ->route('turma.edit', $turma)
            ->withInput()
            ->with('alerta', [
                'tipo' => 'danger',
                'mensagem' => 'Não foi possível atualizar a turma. Tente novamente.',
            ]);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma): RedirectResponse
    {
        try {
            $turma->delete();

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Turma excluída com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir a turma. Tente novamente.',
                ]);
        }
    }

    public function cursos(Turma $turma): View
    {
        $cursos = Curso::query()
            ->where('status', 1)
            ->orderBy('nome')
            ->get();

        $cursosVinculados = TurmaCurso::query()
            ->where('id_turma', $turma->id)
            ->get();

        $cursosAdicionados = [];

        foreach ($cursosVinculados as $vinculo) {
            $cursosAdicionados[] = $vinculo->id_curso;
        }

        return view('turma.cursos', [
            'turma' => $turma,
            'cursos' => $cursos,
            'cursosAdicionados' => $cursosAdicionados,
            'alerta' => session('alerta'),
        ]);
    }

    public function addCursos(Request $request): RedirectResponse
    {
        $idTurma = (int) $request->input('id_turma');
        $cursoRequest = $request->input('curso', []);

        try {
            DB::beginTransaction();

            $cursosVinculados = TurmaCurso::query()
                ->where('id_turma', $idTurma)
                ->get();

            $cursosAdicionados = [];

            foreach ($cursosVinculados as $vinculo) {
                $cursosAdicionados[] = $vinculo->id_curso;
            }

            foreach ($cursosAdicionados as $jaAdicionado) {
                if (! in_array($jaAdicionado, $cursoRequest)) {
                    $cursoRemover = TurmaCurso::query()
                        ->where('id_turma', $idTurma)
                        ->where('id_curso', $jaAdicionado)
                        ->first();

                    if ($cursoRemover) {
                        $cursoRemover->delete();
                    }
                }
            }

            foreach ($cursoRequest as $vaiAdicionar) {
                if (! in_array($vaiAdicionar, $cursosAdicionados)) {
                    TurmaCurso::query()->create([
                        'id_turma' => $idTurma,
                        'id_curso' => $vaiAdicionar,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Cursos atualizados com sucesso.',
                ]);
        } catch (Throwable) {
            DB::rollBack();

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível atualizar os cursos.',
                ]);
        }
    }

    public function alunos(Turma $turma): View
    {
        $alunos = User::query()
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $alunosVinculados = AlunoTurma::query()
            ->where('id_turma', $turma->id)
            ->get();

        $alunosAdicionados = [];

        foreach ($alunosVinculados as $vinculo) {
            $aluno = Aluno::query()->find($vinculo->id_aluno);

            if ($aluno) {
                $alunosAdicionados[] = $aluno->id_usuario;
            }
        }

        return view('turma.alunos', [
            'turma' => $turma,
            'alunos' => $alunos,
            'alunosAdicionados' => $alunosAdicionados,
            'alerta' => session('alerta'),
        ]);
    }

    public function addAlunos(Request $request): RedirectResponse
    {
        $idTurma = (int) $request->input('id_turma');
        $alunoRequest = $request->input('aluno', []);

        try {
            DB::beginTransaction();

            $turma = Turma::query()->findOrFail($idTurma);

            $alunosVinculados = AlunoTurma::query()
                ->where('id_turma', $idTurma)
                ->get();

            $alunosAdicionados = [];

            foreach ($alunosVinculados as $vinculo) {
                $aluno = Aluno::query()->find($vinculo->id_aluno);

                if ($aluno) {
                    $alunosAdicionados[] = $aluno->id_usuario;
                }
            }

            foreach ($alunosAdicionados as $jaAdicionado) {
                if (! in_array($jaAdicionado, $alunoRequest)) {
                    $aluno = Aluno::query()
                        ->where('id_usuario', $jaAdicionado)
                        ->first();

                    if ($aluno) {
                        $vinculoRemover = AlunoTurma::query()
                            ->where('id_turma', $idTurma)
                            ->where('id_aluno', $aluno->id)
                            ->first();

                        if ($vinculoRemover) {
                            $vinculoRemover->delete();
                        }
                    }
                }
            }

            foreach ($alunoRequest as $vaiAdicionar) {
                if (! in_array($vaiAdicionar, $alunosAdicionados)) {
                    $aluno = Aluno::query()
                        ->where('id_usuario', $vaiAdicionar)
                        ->first();

                    if (! $aluno) {
                        $aluno = Aluno::query()->create([
                            'id_usuario' => $vaiAdicionar,
                            'id_escola' => $turma->id_escola,
                            'registro' => 'Aluno'.$vaiAdicionar,
                        ]);
                    }

                    AlunoTurma::query()->create([
                        'id_turma' => $idTurma,
                        'id_aluno' => $aluno->id,
                    ]);
                }
            }

            foreach ($alunoRequest as $idUsuario) {
                $aluno = Aluno::query()
                    ->where('id_usuario', $idUsuario)
                    ->first();

                if (! $aluno) {
                    continue;
                }

                $cursosTurma = TurmaCurso::query()
                    ->where('id_turma', $idTurma)
                    ->get();

                foreach ($cursosTurma as $cursoTurma) {
                    $temCurso = AlunoCurso::query()
                        ->where('id_aluno', $aluno->id)
                        ->where('id_curso', $cursoTurma->id_curso)
                        ->first();

                    if (! $temCurso) {
                        AlunoCurso::query()->create([
                            'id_aluno' => $aluno->id,
                            'id_curso' => $cursoTurma->id_curso,
                            'progresso' => 0,
                            'status' => 0,
                        ]);
                    }

                    $disciplinasCurso = CursoDisciplina::query()
                        ->where('id_curso', $cursoTurma->id_curso)
                        ->get();

                    foreach ($disciplinasCurso as $disciplinaCurso) {
                        $temDisciplina = AlunoDisciplina::query()
                            ->where('id_aluno', $aluno->id)
                            ->where('id_disciplina', $disciplinaCurso->id_disciplina)
                            ->first();

                        if (! $temDisciplina) {
                            AlunoDisciplina::query()->create([
                                'id_aluno' => $aluno->id,
                                'id_disciplina' => $disciplinaCurso->id_disciplina,
                                'status' => 0,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Alunos atualizados com sucesso.',
                ]);
        } catch (Throwable) {
            DB::rollBack();

            return redirect()
                ->route('turma.index')
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Erro ao atualizar alunos.',
                ]);
        }
    }
}
