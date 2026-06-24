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
        $query = Administrativo::query()
            ->with(['usuario', 'escola', 'cargo'])
            ->orderBy('id');

        $hasFilters = $request->filled('id_usuario')
            || $request->filled('id_escola')
            || $request->filled('id_cargo');

        if ($request->filled('pesquisar') && $hasFilters) {
            $query->when(
                $request->filled('id_usuario'),
                fn ($builder) => $builder->where('id_usuario', (int) $request->query('id_usuario'))
            )->when(
                $request->filled('id_escola'),
                fn ($builder) => $builder->where('id_escola', (int) $request->query('id_escola'))
            )->when(
                $request->filled('id_cargo'),
                fn ($builder) => $builder->where('id_cargo', (int) $request->query('id_cargo'))
            );
        }

        $administrativos = $query->paginate(5)->withQueryString();

        $alerta = session('alerta');

        if ($request->filled('pesquisar') && $hasFilters && $administrativos->total() === 0) {
            $alerta = [
                'tipo' => 'warning',
                'mensagem' => 'Administrativo não encontrado',
            ];
        }

        return view('administrativo.index', [
            'administrativos' => $administrativos,
            'usuarios' => User::query()->orderBy('name')->get(),
            'escolas' => Escola::query()->orderBy('razao_social')->get(),
            'cargos' => Cargo::query()->orderBy('titulo')->get(),
            'alerta' => $alerta,
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
    public function destroy(Administrativo $administrativo)
    {
        //
    }
}
