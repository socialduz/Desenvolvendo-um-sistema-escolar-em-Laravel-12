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

    public function scopeWhereLikeInsensitive($query, string $column, ?string $value)
    {
        if (! filled($value)) {
            return $query;
        }

        $search = mb_strtolower(trim($value), 'UTF-8');
        $search = strtr($search, [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ]);

        return $query->whereRaw(
            "translate(lower({$column}), 'áàâãäéèêëíìîïóòôõöúùûüçñ', 'aaaaaeeeeiiiiooooouuuucn') LIKE ?",
            ['%'.$search.'%']
        );
    }
}

