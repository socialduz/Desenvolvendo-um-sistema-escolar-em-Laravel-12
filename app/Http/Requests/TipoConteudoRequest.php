<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoConteudoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', 'string', 'max:100'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'O tipo de conteúdo é obrigatório.',
            'tipo.max' => 'O tipo de conteúdo não pode ter mais de 100 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser Ativo ou Inativo.',
        ];
    }

    /**
     * @return list<string>
     */
    public static function condicoesCadastro(): array
    {
        return [
            'Tipo obrigatório (máx. 100 caracteres).',
            'Status obrigatório (Ativo ou Inativo).',
        ];
    }
}
