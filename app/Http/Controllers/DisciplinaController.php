<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConteudoRequest;
use App\Http\Requests\DisciplinaRequest;
use App\Models\Conteudo;
use App\Models\Disciplina;
use App\Models\TipoConteudo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class DisciplinaController extends Controller
{
    public function index(Request $request): View
    {
        $nome = $request->query('nome');
        $descricao = $request->query('descricao');
        $status = filled($request->query('status')) ? [$request->query('status')] : [0, 1];

        $disciplinas = Disciplina::query()
            ->where('nome', 'LIKE', '%'.$nome.'%')
            ->where('descricao', 'LIKE', '%'.$descricao.'%')
            ->whereIn('status', $status)
            ->paginate(6);

        return view('disciplina.index', compact('disciplinas'));
    }

    public function create(): View
    {
        return view('disciplina.create', [
            'disciplina' => new Disciplina,
            'alerta' => session('alerta'),
            'condicoes' => DisciplinaRequest::condicoesCadastro(),
        ]);
    }

    public function store(DisciplinaRequest $request): RedirectResponse
    {
        try {
            Disciplina::criarPorUsuario($request->validated());

            return redirect()
                ->route('disciplina.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Disciplina cadastrada com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('disciplina.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar a disciplina. Tente novamente.',
                ]);
        }
    }

    public function show(Disciplina $disciplina): View
    {
        $disciplina->load([
            'conteudos' => fn ($query) => $query->with('tipoConteudo')->orderBy('titulo'),
        ]);

        return view('disciplina.show', [
            'disciplina' => $disciplina,
        ]);
    }

    public function edit(Disciplina $disciplina): View
    {
        return view('disciplina.edit', [
            'disciplina' => $disciplina,
            'alerta' => session('alerta'),
        ]);
    }

    public function update(DisciplinaRequest $request, Disciplina $disciplina): RedirectResponse
    {
        try {
            $disciplina->atualizarPorUsuario($request->validated());

            return redirect()
                ->route('disciplina.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Disciplina alterada com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('disciplina.edit', $disciplina)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível alterar a disciplina. Tente novamente.',
                ]);
        }
    }

    public function conteudos(Disciplina $disciplina): View
    {
        $disciplina->load([
            'conteudos' => fn ($query) => $query->with('tipoConteudo')->orderBy('titulo'),
        ]);

        $tipos = TipoConteudo::query()
            ->where('status', 1)
            ->orderBy('tipo')
            ->get();

        return view('disciplina.conteudos', [
            'disciplina' => $disciplina,
            'conteudos' => $disciplina->conteudos,
            'tipos' => $tipos,
            'alerta' => session('alerta'),
            'condicoes' => ConteudoRequest::condicoesCadastro(),
        ]);
    }

    public function addConteudos(ConteudoRequest $request): RedirectResponse
    {
        $disciplinaId = (int) $request->validated('id_disciplina');

        try {
            Conteudo::query()->create($request->validated());

            return redirect()
                ->route('disciplina.conteudos', $disciplinaId)
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Conteúdo cadastrado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('disciplina.conteudos', $disciplinaId)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar o conteúdo. Tente novamente.',
                ]);
        }
    }

    public function destroyConteudo(Conteudo $conteudo): RedirectResponse
    {
        $disciplinaId = $conteudo->id_disciplina;

        try {
            $conteudo->delete();

            return redirect()
                ->route('disciplina.conteudos', $disciplinaId)
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Conteúdo deletado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('disciplina.conteudos', $disciplinaId)
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o conteúdo. Tente novamente.',
                ]);
        }
    }
}
