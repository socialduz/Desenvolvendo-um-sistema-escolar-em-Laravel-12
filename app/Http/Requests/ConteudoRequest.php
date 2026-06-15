<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConteudoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descricao' => ['required', 'string', 'max:200'],
            'status' => ['required', 'integer', 'in:0,1'],
            'observacao' => ['nullable', 'string'],
            'id_disciplina' => ['required', 'integer', 'exists:disciplina,id'],
            'id_tipo' => ['required', 'integer', 'exists:tipo_conteudo,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título do conteúdo é obrigatório.',
            'titulo.max' => 'O título do conteúdo não pode ter mais de 150 caracteres.',
            'descricao.required' => 'A descrição do conteúdo é obrigatória.',
            'descricao.max' => 'A descrição do conteúdo não pode ter mais de 200 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser Ativo ou Inativo.',
            'id_disciplina.required' => 'A disciplina é obrigatória.',
            'id_disciplina.exists' => 'A disciplina informada não foi encontrada.',
            'id_tipo.required' => 'O tipo de conteúdo é obrigatório.',
            'id_tipo.exists' => 'O tipo de conteúdo informado não foi encontrado.',
        ];
    }

    /**
     * @return list<string>
     */
    public static function condicoesCadastro(): array
    {
        return [
            'Título obrigatório (máx. 150 caracteres).',
            'Descrição obrigatória (máx. 200 caracteres).',
            'Tipo de conteúdo obrigatório.',
            'Status obrigatório (Ativo ou Inativo).',
            'Observação opcional.',
        ];
    }
}
