<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:100'],
            'descricao' => ['required', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título do cargo é obrigatório.',
            'titulo.max' => 'O título do cargo não pode ter mais de 100 caracteres.',
            'descricao.required' => 'A descrição do cargo é obrigatória.',
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
            'Título obrigatório (máx. 100 caracteres).',
            'Descrição obrigatória.',
            'Status obrigatório (Ativo ou Inativo).',
        ];
    }
}
