<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aluno extends Model
{
    protected $table = 'aluno';

    public $timestamps = false;

    protected $fillable = ['registro', 'id_usuario', 'id_escola'];

    public function getCursosByAluno($id_aluno)
    {
        $cursos = DB::table('aluno_curso')
            ->select('aluno_curso.progresso', 'aluno_curso.nota',
                'curso.id', 'curso.nome', 'curso.descricao', 'aluno_curso.id_aluno')
            ->join('curso', 'curso.id', '=', 'aluno_curso.id_curso')
            ->join('aluno', 'aluno.id', '=', 'aluno_curso.id_aluno')
            ->where('aluno.id', $id_aluno)
            ->get();

        return $cursos;
    }

    public function getDisciplinaByAlunoCurso($id_aluno, $id_curso)
    {
        $disciplina = DB::table('aluno_disciplina')
            ->select('disciplina.id', 'aluno_disciplina.status', 'disciplina.nome', 'disciplina.descricao')
            ->join('disciplina', 'disciplina.id', '=', 'aluno_disciplina.id_disciplina')
            ->join('curso_disciplina', 'curso_disciplina.id_disciplina', '=', 'aluno_disciplina.id_disciplina')
            ->where('aluno_disciplina.id_aluno', $id_aluno)
            ->where('curso_disciplina.id_curso', $id_curso)
            ->distinct()
            ->get();

        return $disciplina;
    }

    public static function getCursoByAlunoDisciplina($id_aluno, $id_curso, $id_disciplina)
    {
        $disciplina = DB::table('aluno_curso')
            ->select('aluno_curso.id', 'aluno_curso.id_aluno',
                'aluno_curso.id_curso', 'curso_disciplina.id_disciplina')
            ->join('curso', 'curso.id', '=', 'aluno_curso.id_curso')
            ->join('curso_disciplina', 'curso_disciplina.id_curso', '=', 'curso.id')
            ->where('aluno_curso.id_aluno', $id_aluno)
            ->where('curso_disciplina.id_curso', $id_curso)
            ->where('curso_disciplina.id_disciplina', $id_disciplina)
            ->distinct()
            ->first();

        return $disciplina;
    }

    public static function getCursosMesmaDisciplina($id_aluno, $id_disciplina)
    {
        $cursos = DB::table('curso_disciplina')
            ->select('aluno_curso.id', 'aluno_curso.id_curso', 'aluno_disciplina.id_disciplina')
            ->join('aluno_disciplina', 'aluno_disciplina.id_disciplina', '=', 'curso_disciplina.id_disciplina')
            ->join('aluno_curso', 'aluno_curso.id_curso', '=', 'curso_disciplina.id_curso')
            ->where('aluno_disciplina.id_aluno', $id_aluno)
            ->where('curso_disciplina.id_disciplina', $id_disciplina)
            ->distinct()
            ->get();

        return $cursos;
    }

    public static function geraProgressoCurso($id_aluno, $id_curso)
    {
        $disciplina = DB::table('aluno_disciplina')
            ->select('aluno_disciplina.id', 'aluno_disciplina.id_aluno', 'curso.id as curso_id',
                'disciplina.id as disciplina_id', 'aluno_disciplina.status')
            ->join('curso_disciplina', 'curso_disciplina.id_disciplina', '=', 'aluno_disciplina.id_disciplina')
            ->join('disciplina', 'disciplina.id', '=', 'curso_disciplina.id_disciplina')
            ->join('curso', 'curso.id', '=', 'curso_disciplina.id_curso')
            ->where('aluno_disciplina.id_aluno', $id_aluno)
            ->where('curso.id', $id_curso)
            ->distinct()
            ->get();

        if (count($disciplina) == 0) {
            return 0;
        }

        $concluido = 0;

        foreach ($disciplina as $d) {
            if ($d->status == 1) {
                $concluido++;
            }
        }

        $totalizadorProgresso = ($concluido / count($disciplina)) * 100.0;
        $totalizadorProgresso = number_format($totalizadorProgresso, 2, '.', '');

        return $totalizadorProgresso;
    }
}
