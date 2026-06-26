<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Aluno;
use App\Models\AlunoCurso;
use App\Models\AlunoDisciplina;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Exception;
use Throwable;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cpf = $request->query('cpf');
        $rg = $request->query('rg');
        $nome = $request->query('nome');
        $status = filled($request->query('status')) ? [$request->query('status')] : [0, 1];

        $usuarios = User::query()
            ->whereLikeInsensitive('cpf', $cpf)
            ->whereLikeInsensitive('rg', $rg)
            ->whereLikeInsensitive('name', $nome)
            ->whereIn('status', $status)
            ->paginate(5);

        return view('usuario.index', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            User::create($request->validated());
    
            return redirect()
                ->route('usuario.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Usuário cadastrado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('usuario.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar o usuário. Tente novamente.',
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario): View
    {
        return view('usuario.show', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario): View
    {
        return view('usuario.edit', [
            'usuario' => $usuario,
            'alerta' => session('alerta'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $usuario): RedirectResponse
    {
        try {
            $data = $request->validated();

            if (blank($request->password)) {
                unset($data['password']);
            }

            $usuario->update($data);

            return redirect()
                ->route('usuario.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Usuário atualizado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('usuario.edit', $usuario)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível atualizar o usuário. Tente novamente.',
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario): RedirectResponse
    {
        try {
            $usuario->delete();

            return redirect()
                ->route('usuario.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Usuário excluído com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o usuário. Tente novamente.',
                ]);
        }
    }

    public function cursos($id): View|RedirectResponse
    {
        $modelAluno = Aluno::query()
            ->where('id_usuario', $id)
            ->first();

        if (! $modelAluno) {
            return redirect()
                ->route('usuario.index')
                ->with('alerta', [
                    'tipo' => 'warning',
                    'mensagem' => 'Este usuário não possui registro de aluno.',
                ]);
        }

        $cursosAluno = $modelAluno->getCursosByAluno($modelAluno->id);
        $arrayCursoAluno = [];

        foreach ($cursosAluno as $cursoAluno) {
            $arrayCursoAluno[$cursoAluno->id]['curso'] = $cursoAluno;

            $disciplinaAlunoCurso = $modelAluno
                ->getDisciplinaByAlunoCurso($modelAluno->id, $cursoAluno->id);

            foreach ($disciplinaAlunoCurso as $disciplina) {
                $arrayCursoAluno[$cursoAluno->id]['disciplinas'][] = $disciplina;
            }
        }

        return view('usuario.cursos', compact('arrayCursoAluno'));
    }

    public function concluirDisciplina(int $id_aluno, int $id_curso, int $id_disciplina): RedirectResponse
    {
        $alunoDisciplina = AlunoDisciplina::query()
            ->where('id_aluno', $id_aluno)
            ->where('id_disciplina', $id_disciplina)
            ->first();

        if (! $alunoDisciplina) {
            return redirect()->back()->with('error', 'Não foi possível concluir a disciplina');
        }

        DB::beginTransaction();

        try {
            AlunoDisciplina::query()
                ->where('id', $alunoDisciplina->id)
                ->update(['status' => 1]);

            $cursosComDisciplina = Aluno::getCursosMesmaDisciplina($id_aluno, $id_disciplina);

            foreach ($cursosComDisciplina as $curso) {
                $progressoCurso = Aluno::geraProgressoCurso($id_aluno, $curso->id_curso);
                AlunoCurso::query()
                    ->find($curso->id)
                    ->update(['progresso' => $progressoCurso]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Disciplina finalizada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
