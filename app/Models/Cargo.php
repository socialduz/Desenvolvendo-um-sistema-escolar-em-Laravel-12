<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'titulo',
        'status',
    ];

    protected $guarded = [
        'id',
        'dt_create',
        'dt_update',
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

    public static function criarPorUsuario(array $dados): self
    {
        $hoje = now()->toDateString();

        $registro = new static;
        $registro->fill(collect($dados)->only(['descricao', 'titulo', 'status'])->all());
        $registro->dt_create = $hoje;
        $registro->dt_update = $hoje;
        $registro->save();

        return $registro;
    }

    public function atualizarPorUsuario(array $dados): bool
    {
        $this->fill(collect($dados)->only(['descricao', 'titulo', 'status'])->all());
        $this->dt_update = now()->toDateString();

        return $this->save();
    }
}
