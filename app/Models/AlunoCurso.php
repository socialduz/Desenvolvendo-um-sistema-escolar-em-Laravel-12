<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AlunoCurso extends Model
{
    protected $table = 'aluno_curso';

    public $timestamps = false;

    protected $fillable = [
        'id_aluno',
        'id_curso',
        'progresso',
        'status',
        'nota',
    ];
}
