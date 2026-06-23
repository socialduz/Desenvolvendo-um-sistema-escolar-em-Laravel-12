<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $table = 'escola';

    public $timestamps = false;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'codigo_escola',
        'cnpj',
        'endereco',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'telefone',
        'data_inauguracao',
        'status',
        'observacao',
    ];
}
