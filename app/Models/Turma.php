<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turma extends Model
{
    protected $table = 'turma';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'dt_inicio',
        'dt_termino',
        'status',
        'observacao',
        'id_escola',
        'id_professor',
    ];

    public function escola(): BelongsTo
    {
        return $this->belongsTo(Escola::class, 'id_escola');
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class, 'id_professor');
    }
}
