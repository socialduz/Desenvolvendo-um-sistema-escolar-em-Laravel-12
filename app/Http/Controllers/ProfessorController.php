<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessorRequest;
use App\Models\Escola;
use App\Models\Professor;
use App\Models\Search\ProfessorSeach;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProfessorController extends Controller
{
    public function index(Request $request): View
    {
        $escolas = Escola::query()->get();
        $usuarios = User::query()->get();

        $modelSearchProfessor = new ProfessorSeach;
        $professores = $modelSearchProfessor->search($request);

        return view('professor.index', [
            'professores' => $professores,
            'escolas' => $escolas,
            'usuarios' => $usuarios,
        ]);
    }

    public function show(Professor $professor): View
    {
        return view('professor.show', [
            'professor' => $professor->load(['usuario', 'escola']),
        ]);
    }

    public function create(): View
    {
        return view('professor.create', [
            'usuarios' => User::query()->orderBy('name')->get(),
            'escolas' => Escola::query()->orderBy('razao_social')->get(),
            'alerta' => session('alerta'),
        ]);
    }
    public function store(ProfessorRequest $request): RedirectResponse
    {
        try {
            Professor::create([
                'id_usuario' => $request->id_usuario,
                'id_escola' => $request->id_escola,
                'registro' => $request->registro,
                'salario' => $request->salario,
                'status' => $request->status ?? 1,
                'telefone' => $request->telefone,
                'observacao' => $request->observacao,
                'data_cadastro' => $request->data_cadastro,
            ]);
    
            return redirect()
                ->route('professor.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Professor cadastrado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('professor.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar o professor. Tente novamente.',
                ]);
        }
    }

    public function edit(Professor $professor): View
    {
        return view('professor.edit', [
            'professor' => $professor,
            'usuarios' => User::query()->orderBy('name')->get(),
            'escolas' => Escola::query()->orderBy('razao_social')->get(),
            'alerta' => session('alerta'),
        ]);
    }
    public function update(ProfessorRequest $request, Professor $professor): RedirectResponse
    {
        try {
            $professor->update([
                'id_usuario' => $request->id_usuario,
                'id_escola' => $request->id_escola,
                'registro' => $request->registro,
                'salario' => $request->salario,
                'status' => $request->status ?? 1,
                'telefone' => $request->telefone,
                'observacao' => $request->observacao,
                'data_cadastro' => $request->data_cadastro,
            ]);

            return redirect()
                ->route('professor.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Professor atualizado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('professor.edit', $professor)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível atualizar o professor. Tente novamente.',
                ]);
        }
    }

    public function destroy(Professor $professor): RedirectResponse
    {
        try {
            $professor->delete();

            return redirect()
                ->route('professor.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Professor excluído com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o professor. Tente novamente.',
                ]);
        }
    }
}


