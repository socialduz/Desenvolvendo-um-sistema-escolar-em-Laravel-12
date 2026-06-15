<?php

namespace App\Http\Controllers;

use App\Http\Requests\CargoRequest;
use App\Models\Cargo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CargoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Cargo::query()->orderBy('titulo');

        $hasFilters = $request->filled('titulo')
            || $request->filled('descricao')
            || $request->filled('status');

        if ($request->filled('pesquisar') && $hasFilters) {
            $query->whereLikeInsensitive('titulo', $request->query('titulo'))
                ->whereLikeInsensitive('descricao', $request->query('descricao'))
                ->when(
                    $request->filled('status'),
                    fn ($builder) => $builder->where('status', (int) $request->query('status'))
                );
        }

        $cargos = $query->paginate(4)->withQueryString();

        $alerta = session('alerta');

        if ($request->filled('pesquisar') && $hasFilters && $cargos->total() === 0) {
            $alerta = [
                'tipo' => 'warning',
                'mensagem' => 'Cargo não encontrado',
            ];
        }

        return view('cargo.index', [
            'cargos' => $cargos,
            'alerta' => $alerta,
        ]);
    }

    public function create(): View
    {
        return view('cargo.create', [
            'cargo' => new Cargo,
            'alerta' => session('alerta'),
            'condicoes' => CargoRequest::condicoesCadastro(),
        ]);
    }

    public function store(CargoRequest $request): RedirectResponse
    {
        try {
            if (config('app.debug') && $request->input('titulo') === 'SIMULAR_ERRO_CADASTRO') {
                throw new RuntimeException('Erro de cadastro simulado para teste.');
            }

            Cargo::criarPorUsuario($request->validated());

            return redirect()
                ->route('cargo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Cargo cadastrado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('cargo.create')
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível cadastrar o cargo. Tente novamente.',
                ]);
        }
    }

    public function show(Cargo $cargo): View
    {
        return view('cargo.show', [
            'cargo' => $cargo,
        ]);
    }

    public function edit(Cargo $cargo): View
    {
        return view('cargo.edit', [
            'cargo' => $cargo,
            'alerta' => session('alerta'),
        ]);
    }

    public function update(CargoRequest $request, Cargo $cargo): RedirectResponse
    {
        try {
            $cargo->atualizarPorUsuario($request->validated());

            return redirect()
                ->route('cargo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Cargo alterado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('cargo.edit', $cargo)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível alterar o cargo. Tente novamente.',
                ]);
        }
    }

    public function destroy(Cargo $cargo): RedirectResponse
    {
        try {
            $cargo->delete();

            return redirect()
                ->route('cargo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Cargo deletado com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o cargo. Tente novamente.',
                ]);
        }
    }
}
