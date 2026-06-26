<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Curso extends Model
{
    protected $table = 'curso';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'status',
        'dt_cadastro',
        'observacao',
        'preco',
    ];

    public static function getAlunosByCurso(int $id_curso, int $id_turma): Collection
    {
        return DB::table('aluno_curso')
            ->select(
                'aluno_curso.nota',
                'users.name',
                'aluno_curso.id',
                'aluno_turma.id_turma'
            )
            ->join('curso', 'curso.id', '=', 'aluno_curso.id_curso')
            ->join('aluno', 'aluno.id', '=', 'aluno_curso.id_aluno')
            ->join('aluno_turma', 'aluno_turma.id_aluno', '=', 'aluno.id')
            ->join('users', 'users.id', '=', 'aluno.id_usuario')
            ->where('curso.id', $id_curso)
            ->where('aluno_turma.id_turma', $id_turma)
            ->get();
    }

    public static function podeEditarCurso($id_turma)
    {
        $dadosUser = Auth::user();

        $podeEditar = DB::table('turma')
            ->select('professor.id_usuario', 'turma.id')
            ->join('professor', 'professor.id', '=', 'turma.id_professor')
            ->join('users', 'users.id', '=', 'professor.id_usuario')
            ->where('users.id', $dadosUser->id)
            ->where('turma.id', $id_turma)
            ->get();

        return count($podeEditar) > 0 ? 1 : 0;
    }

    public function scopeWhereLikeInsensitive($query, string $column, ?string $value)
    {
        if (! filled($value)) {
            return $query;
        }

        $search = mb_strtolower(trim($value), 'UTF-8');
        $search = strtr($search, [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ]);

        return $query->whereRaw(
            "translate(lower({$column}), 'áàâãäéèêëíìîïóòôõöúùûüçñ', 'aaaaaeeeeiiiiooooouuuucn') LIKE ?",
            ['%'.$search.'%']
        );
    }
}
