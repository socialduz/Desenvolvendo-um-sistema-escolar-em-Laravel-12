<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Escola;
use App\Models\Professor;
use App\Models\Turma;
use Illuminate\View\View;

class DashBoardController extends Controller
{
    public function index(): View
    {
        $contadorEscola = Escola::count();
        $contadorCurso = Curso::count();
        $contadorTurma = Turma::count();
        $contadorProfessor = Professor::count();

        return view('dashboard.index', compact(
            'contadorEscola',
            'contadorCurso',
            'contadorTurma',
            'contadorProfessor'
        ));
    }
}
