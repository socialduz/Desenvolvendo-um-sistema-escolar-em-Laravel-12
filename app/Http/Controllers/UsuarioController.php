<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Throwable;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query()->orderBy('name');

        $hasFilters = $request->filled('cpf')
            || $request->filled('rg')
            || $request->filled('name')
            || $request->filled('status');

        if ($request->filled('pesquisar') && $hasFilters) {
            $query->whereLikeInsensitive('cpf', $request->query('cpf'))
                ->whereLikeInsensitive('rg', $request->query('rg'))
                ->whereLikeInsensitive('name', $request->query('name'))
                ->when(
                    $request->filled('status'),
                    fn ($builder) => $builder->where('status', (int) $request->query('status'))
                );
        }

        $usuarios = $query->paginate(5)->withQueryString();

        $alerta = session('alerta');

        if ($request->filled('pesquisar') && $hasFilters && $usuarios->total() === 0) {
            $alerta = [
                'tipo' => 'warning',
                'mensagem' => 'Usuário não encontrado',
            ];
        }

        return view('usuario.index', [
            'usuarios' => $usuarios,
            'alerta' => $alerta,
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
}
