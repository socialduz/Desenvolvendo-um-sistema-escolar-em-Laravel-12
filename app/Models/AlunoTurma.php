<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoTurma extends Model
{
    protected $table = 'aluno_turma';

    public $timestamps = false;

    protected $fillable = [
        'id_turma',
        'id_aluno',
    ];
}
