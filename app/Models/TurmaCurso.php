<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurmaCurso extends Model
{
    protected $table = 'turma_curso';

  

    protected $fillable = [
        'id_turma',
        'id_curso',
    ];
}
