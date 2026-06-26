<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoDisciplina extends Model
{
    protected $table = 'aluno_disciplina';

    public $timestamps = false;

    protected $fillable = [
    'id_aluno',
    'id_disciplina',
    'status',
];
}
