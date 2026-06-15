<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoConteudoRequest;
use App\Models\TipoConteudo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class TipoConteudoController extends Controller
{
    public function index(Request $request): View
    {
        $query = TipoConteudo::query()->orderBy('tipo');

        $hasFilters = $request->filled('tipo') || $request->filled('status');

        if ($request->filled('pesquisar') && $hasFilters) {
            $query->whereLikeInsensitive('tipo', $request->query('tipo'))
                ->when(
                    $request->filled('status'),
                    fn ($builder) => $builder->where('status', (int) $request->query('status'))
                );
        }

        $tipos = $query->paginate(4)->withQueryString();

        $alerta = session('alerta');

        if ($request->filled('pesquisar') && $hasFilters && $tipos->total() === 0) {
            $alerta = [
                'tipo' => 'warning',
                'mensagem' => 'Tipo de conteúdo não encontrado',
            ];
        }

        return view('tipo-conteudo.index', [
            'tipos' => $tipos,
            'alerta' => $alerta,
        ]);
    }

    public function create(): View
    {
        return view('tipo-conteudo.create', [
            'tipoConteudo' => new TipoConteudo,
            'alerta' => session('alerta'),
            'condicoes' => TipoConteudoRequest::condicoesCadastro(),
        ]);
    }

    public function store(TipoConteudoRequest $request): RedirectResponse
    {
        try {
            TipoConteudo::criarPorUsuario($request->validated());

            return redirect()
                ->route('tipo-conteudo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Tipo de conteúdo cadastrado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('tipo-conteudo.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar o tipo de conteúdo. Tente novamente.',
                ]);
        }
    }

    public function show(TipoConteudo $tipoConteudo): View
    {
        $tipoConteudo->load([
            'conteudos' => fn ($query) => $query->with('disciplina')->orderBy('titulo'),
        ]);

        $disciplinas = $tipoConteudo->conteudos
            ->pluck('disciplina')
            ->filter()
            ->unique('id')
            ->sortBy('nome')
            ->values();

        return view('tipo-conteudo.show', [
            'tipoConteudo' => $tipoConteudo,
            'disciplinas' => $disciplinas,
        ]);
    }

    public function edit(TipoConteudo $tipoConteudo): View
    {
        return view('tipo-conteudo.edit', [
            'tipoConteudo' => $tipoConteudo,
            'alerta' => session('alerta'),
        ]);
    }

    public function update(TipoConteudoRequest $request, TipoConteudo $tipoConteudo): RedirectResponse
    {
        try {
            $tipoConteudo->atualizarPorUsuario($request->validated());

            return redirect()
                ->route('tipo-conteudo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Tipo de conteúdo alterado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('tipo-conteudo.edit', $tipoConteudo)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível alterar o tipo de conteúdo. Tente novamente.',
                ]);
        }
    }

    public function destroy(TipoConteudo $tipoConteudo): RedirectResponse
    {
        try {
            $tipoConteudo->delete();

            return redirect()
                ->route('tipo-conteudo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Tipo de conteúdo deletado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o tipo de conteúdo. Tente novamente.',
                ]);
        }
    }
}
