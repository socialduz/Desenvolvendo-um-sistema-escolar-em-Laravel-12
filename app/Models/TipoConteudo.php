<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoConteudo extends Model
{
    protected $table = 'tipo_conteudo';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'status',
    ];

    protected $guarded = [
        'id',
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
        $registro = new static;
        $registro->fill(collect($dados)->only(['tipo', 'status'])->all());
        $registro->save();

        return $registro;
    }

    public function atualizarPorUsuario(array $dados): bool
    {
        $this->fill(collect($dados)->only(['tipo', 'status'])->all());

        return $this->save();
    }

    public function conteudos(): HasMany
    {
        return $this->hasMany(Conteudo::class, 'id_tipo', 'id');
    }
}
