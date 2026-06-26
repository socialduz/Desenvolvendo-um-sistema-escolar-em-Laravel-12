<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Curso;
use App\Models\CursoDisciplina;
use App\Models\Disciplina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class CursoController extends Controller
{
    public function index(Request $request): View
    {
        $nome = $request->query('nome');
        $descricao = $request->query('descricao');
        $status = filled($request->query('status')) ? [$request->query('status')] : [0, 1];

        $cursos = Curso::query()
            ->whereLikeInsensitive('nome', $nome)
            ->whereLikeInsensitive('descricao', $descricao)
            ->whereIn('status', $status)
            ->paginate(6)
            ->withQueryString();

        return view('curso.index', [
            'cursos' => $cursos,
        ]);
    }

    public function create(): View
    {
        return view('curso.create');
    }

    public function store(CursoRequest $request): RedirectResponse
    {
        try {
            Curso::query()->create([
                'nome' => $request['nome'],
                'descricao' => $request['descricao'],
                'status' => $request['status'],
                'preco' => $this->normalizePreco($request->input('preco')),
                'observacao' => $request['observacao'],
                'dt_cadastro' => date('Y-m-d'),
            ]);

            return redirect()
                ->route('curso.index')
                ->with('success', 'Curso cadastrado com sucesso!!');
        } catch (Throwable) {
            return redirect()
                ->route('curso.create')
                ->withInput()
                ->with('error', 'Não foi possível cadastrar o curso!!');
        }
    }

    public function show(Curso $curso): View
    {
        return view('curso.show', compact('curso'));
    }

    public function edit(Curso $curso): View
    {
        return view('curso.edit', compact('curso'));
    }

    public function update(CursoRequest $request, Curso $curso): RedirectResponse
    {
        try {
            $curso->update([
                'nome' => $request['nome'],
                'descricao' => $request['descricao'],
                'status' => $request['status'],
                'preco' => $this->normalizePreco($request->input('preco')),
                'observacao' => $request['observacao'],
            ]);

            return redirect()
                ->route('curso.index')
                ->with('success', 'Curso atualizado com sucesso!!');
        } catch (Throwable) {
            return redirect()
                ->route('curso.edit', $curso)
                ->withInput()
                ->with('error', 'Não foi possível atualizar o curso!!');
        }
    }

    private function normalizePreco(?string $preco): ?float
    {
        if (! filled($preco)) {
            return null;
        }

        $preco = trim($preco);

        if (str_contains($preco, ',')) {
            $preco = str_replace('.', '', $preco);
            $preco = str_replace(',', '.', $preco);
        }

        return (float) $preco;
    }

    public function destroy(string $id): void
    {
        //
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
            CursoDisciplina::query()
                ->where('id_curso', $idCurso)
                ->delete();

            foreach ($disciplinas as $disciplina) {
                CursoDisciplina::query()->create([
                    'id_curso' => $idCurso,
                    'id_disciplina' => $disciplina,
                ]);
            }

            return redirect()
                ->route('curso.index')
                ->with('success', 'Disciplinas atualizadas com sucesso!!');
        } catch (Throwable) {
            return redirect()
                ->route('curso.index')
                ->with('error', 'Não foi possível atualizar as disciplinas.');
        }
    }
}
