<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EscolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
{
    $query = Escola::query()->orderBy('nome_fantasia');

    $hasFilters = $request->filled('codigo_escola')
        || $request->filled('nome_fantasia')
        || $request->filled('razao_social')
        || $request->filled('status');

    if ($request->filled('pesquisar') && $hasFilters) {
        $query->whereLikeInsensitive('codigo_escola', $request->query('codigo_escola'))
            ->whereLikeInsensitive('nome_fantasia', $request->query('nome_fantasia'))
            ->whereLikeInsensitive('razao_social', $request->query('razao_social'))
            ->when(
                $request->filled('status'),
                fn ($builder) => $builder->where('status', (int) $request->query('status'))
            );
    }

    $escolas = $query->paginate(5)->withQueryString();

    $alerta = session('alerta');

    if ($request->filled('pesquisar') && $hasFilters && $escolas->total() === 0) {
        $alerta = [
            'tipo' => 'warning',
            'mensagem' => 'Escola não encontrada',
        ];
    }

    return view('escola.index', [
        'escolas' => $escolas,
        'alerta' => $alerta,
    ]);
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
    public function show(Escola $escola)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Escola $escola)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Escola $escola)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Escola $escola)
    {
        //
    }
}
