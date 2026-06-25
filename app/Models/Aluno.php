<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'aluno';

    protected $fillable = [
        'id_usuario',
        'id_escola',
        'registro',
    ];
}
