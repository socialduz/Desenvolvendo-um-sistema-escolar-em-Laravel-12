<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TipoConteudoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\DisciplinaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashBoardController::class, 'index']);

// Curso
Route::get('curso/{curso}/disciplinas', [CursoController::class, 'disciplinas'])->name('curso.disciplinas');
Route::post('curso/add-disciplinas', [CursoController::class, 'addDisciplinas'])->name('curso.add-disciplinas');
Route::resource('curso', CursoController::class);
Route::resource('tipo-conteudo', TipoConteudoController::class);
Route::resource('cargo', CargoController::class);
Route::get('disciplina/{disciplina}/conteudos', [DisciplinaController::class, 'conteudos'])->name('disciplina.conteudos');
Route::post('disciplina/add-conteudos', [DisciplinaController::class, 'addConteudos'])->name('disciplina.add-conteudos');
Route::delete('disciplina/conteudo/{conteudo}', [DisciplinaController::class, 'destroyConteudo'])->name('disciplina.destroy-conteudo');
Route::resource('disciplina', DisciplinaController::class)->except(['destroy']);