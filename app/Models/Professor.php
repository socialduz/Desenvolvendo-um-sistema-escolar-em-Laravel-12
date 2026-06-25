<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Professor extends Model
{
    protected $table = 'professor';

    protected $fillable = [
        'id_usuario',
        'id_escola',
        'registro',
        'salario',
        'status',
        'data_cadastro',
        'observacao',
        'telefone',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function escola(): BelongsTo
    {
        return $this->belongsTo(Escola::class, 'id_escola');
    }
}