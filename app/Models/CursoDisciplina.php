<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoDisciplina extends Model
{
    protected $table = 'curso_disciplina';

    public $timestamps = false;

    protected $fillable = [
        'id_curso',
        'id_disciplina',
    ];
}
