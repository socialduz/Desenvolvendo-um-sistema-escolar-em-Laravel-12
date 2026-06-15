<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['required', 'string', 'max:200'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da disciplina é obrigatório.',
            'nome.max' => 'O nome da disciplina não pode ter mais de 150 caracteres.',
            'descricao.required' => 'A descrição da disciplina é obrigatória.',
            'descricao.max' => 'A descrição da disciplina não pode ter mais de 200 caracteres.',
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
            'Nome obrigatório (máx. 150 caracteres).',
            'Descrição obrigatória (máx. 200 caracteres).',
            'Status obrigatório (Ativo ou Inativo).',
        ];
    }
}
