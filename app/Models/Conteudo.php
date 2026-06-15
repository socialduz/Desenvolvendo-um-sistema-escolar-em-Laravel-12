<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conteudo extends Model
{
    protected $table = 'conteudo';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'observacao',
        'id_disciplina',
        'id_tipo',
    ];

    protected $guarded = [
        'id',
    ];

    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class, 'id_disciplina');
    }

    public function tipoConteudo(): BelongsTo
    {
        return $this->belongsTo(TipoConteudo::class, 'id_tipo');
    }
}
