<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\CursoDisciplina;
use App\Models\Disciplina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Curso::query();

        $hasFilters = $request->filled('nome')
            || $request->filled('descricao')
            || $request->filled('status');

        if ($request->filled('pesquisar') && $hasFilters) {
            $query->whereLikeInsensitive('nome', $request->query('nome'))
                ->whereLikeInsensitive('descricao', $request->query('descricao'))
                ->when(
                    $request->filled('status'),
                    fn ($builder) => $builder->where('status', (int) $request->query('status'))
                );
        }

        $cursos = $query->paginate(4)->withQueryString();

        return view('curso.index', [
            'cursos' => $cursos,
            'alerta' => session('alerta'),
        ]);
    }

    public function disciplinas(Curso $curso): View
    {
        $disciplinas = Disciplina::query()->orderBy('nome')->get();

        $disciplinasCadastradas = CursoDisciplina::query()
            ->where('id_curso', $curso->id)
            ->select('id_disciplina')
            ->get();

        $arrayDisciplinas = [];

        foreach ($disciplinasCadastradas as $disciplina) {
            $arrayDisciplinas[] = $disciplina->id_disciplina;
        }

        return view('curso.disciplinas', [
            'curso' => $curso,
            'disciplinas' => $disciplinas,
            'arrayDisciplinas' => $arrayDisciplinas,
            'alerta' => session('alerta'),
        ]);
    }

    public function addDisciplinas(Request $request): RedirectResponse
    {
        $idCurso = (int) $request->input('id_curso');
        $disciplinas = $request->input('disciplina', []);

        try {
            DB::beginTransaction();

            CursoDisciplina::query()
                ->where('id_curso', $idCurso)
                ->delete();

            foreach ($disciplinas as $disciplina) {
                CursoDisciplina::query()->create([
                    'id_curso' => $idCurso,
                    'id_disciplina' => $disciplina,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('curso.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Disciplinas atualizadas com sucesso.',
                ]);
        } catch (Throwable) {
            DB::rollBack();

            return redirect()
                ->route('curso.index')
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível atualizar as disciplinas.',
                ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
