<?php

namespace App\Http\Controllers;

use App\Http\Requests\EscolaRequest;
use App\Models\Escola;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class EscolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $codigo_escola = $request->query('codigo_escola');
        $nome_fantasia = $request->query('nome_fantasia');
        $razao_social = $request->query('razao_social');
        $status = filled($request->query('status')) ? [$request->query('status')] : [0, 1];

        $escolas = Escola::query()
            ->whereLikeInsensitive('codigo_escola', $codigo_escola)
            ->whereLikeInsensitive('nome_fantasia', $nome_fantasia)
            ->whereLikeInsensitive('razao_social', $razao_social)
            ->whereIn('status', $status)
            ->paginate(5);

        return view('escola.index', [
            'escolas' => $escolas,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{
    return view('escola.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(EscolaRequest $request): RedirectResponse
{
    try {
        Escola::create($request->validated());

        return redirect()
            ->route('escola.index')
            ->with('alerta', [
                'tipo' => 'success',
                'mensagem' => 'Escola cadastrada com sucesso.',
            ]);
    } catch (Throwable) {
        return redirect()
            ->route('escola.create')
            ->withInput()
            ->with('alerta', [
                'tipo' => 'danger',
                'mensagem' => 'Não foi possível cadastrar a escola. Tente novamente.',
            ]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Escola $escola): View
    {
        return view('escola.show', [
            'escola' => $escola,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Escola $escola): View
{
    return view('escola.edit', [
        'escola' => $escola,
        'alerta' => session('alerta'),
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(EscolaRequest $request, Escola $escola): RedirectResponse
    {
        try {
            $escola->update($request->validated());

            return redirect()
                ->route('escola.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Escola atualizada com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->route('escola.edit', $escola)
                ->withInput()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível atualizar a escola. Tente novamente.',
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Escola $escola): RedirectResponse
    {
        try {
            $escola->delete();

            return redirect()
                ->route('escola.index')
                ->with('alerta', [
                    'tipo' => 'success',
                    'mensagem' => 'Escola excluída com sucesso.',
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->with('alerta', [
                    'tipo' => 'danger',
                    'mensagem' => 'Não foi possível excluir a escola. Tente novamente.',
                ]);
        }
    }
}
