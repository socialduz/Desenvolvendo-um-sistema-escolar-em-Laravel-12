<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\Cargo;
use App\Models\Escola;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\AdministrativoRequest;
use Illuminate\Http\RedirectResponse;
use Throwable;

class AdministrativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $nome = $request->query('nome');
        $escola = $request->query('escola');
        $cargo = $request->query('cargo');

        $administrativos = Administrativo::query()
            ->with(['usuario', 'escola', 'cargo'])
            ->when(filled($nome), function ($query) use ($nome) {
                $query->whereHas('usuario', fn ($q) => $q->whereLikeInsensitive('name', $nome));
            })
            ->when(filled($escola), function ($query) use ($escola) {
                $query->whereHas('escola', fn ($q) => $q->whereLikeInsensitive('razao_social', $escola));
            })
            ->when(filled($cargo), function ($query) use ($cargo) {
                $query->whereHas('cargo', fn ($q) => $q->whereLikeInsensitive('titulo', $cargo));
            })
            ->paginate(6)
            ->withQueryString();

        return view('administrativo.index', [
            'administrativos' => $administrativos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{
    return view('administrativo.create', [
        'usuarios' => User::query()->orderBy('name')->get(),
        'escolas' => Escola::query()->orderBy('razao_social')->get(),
        'cargos' => Cargo::query()->orderBy('titulo')->get(),
        'alerta' => session('alerta'),
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdministrativoRequest $request): RedirectResponse
{
    try {
        Administrativo::create($request->validated());

        return redirect()
            ->route('administrativo.index')
            ->with('alerta', [
                'tipo' => 'success',
                'mensagem' => 'Administrativo cadastrado com sucesso.',
            ]);
    } catch (Throwable) {
        return redirect()
            ->route('administrativo.create')
            ->withInput()
            ->with('alerta', [
                'tipo' => 'danger',
                'mensagem' => 'Não foi possível cadastrar o administrativo. Tente novamente.',
            ]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Administrativo $administrativo): View
    {
        return view('administrativo.show', [
            'administrativo' => $administrativo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrativo $administrativo): View
{
    return view('administrativo.edit', [
        'administrativo' => $administrativo,
        'usuarios' => User::query()->orderBy('name')->get(),
        'escolas' => Escola::query()->orderBy('razao_social')->get(),
        'cargos' => Cargo::query()->orderBy('titulo')->get(),
        'alerta' => session('alerta'),
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(AdministrativoRequest $request, Administrativo $administrativo): RedirectResponse
{
    try {
        $administrativo->update($request->validated());

        return redirect()
            ->route('administrativo.index')
            ->with('alerta', [
                'tipo' => 'success',
                'mensagem' => 'Administrativo atualizado com sucesso.',
            ]);
    } catch (Throwable) {
        return redirect()
            ->route('administrativo.edit', $administrativo)
            ->withInput()
            ->with('alerta', [
                'tipo' => 'danger',
                'mensagem' => 'Não foi possível atualizar o administrativo. Tente novamente.',
            ]);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrativo $administrativo): RedirectResponse
    {
        try {
            $administrativo->delete();

            return redirect()
                ->route('administrativo.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Administrativo excluído com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir o administrativo. Tente novamente.',
                ]);
        }
    }
}
