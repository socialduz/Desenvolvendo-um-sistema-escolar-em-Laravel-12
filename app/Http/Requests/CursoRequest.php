<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'max:150|required',
            'descricao' => 'max:200|required',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'Campo nome é obrigatório',
            'nome.max' => 'Campo nome não pode ultrapassar :max caracteres',
            'descricao.required' => 'Campo Descrição é obrigatório',
            'descricao.max' => 'Campo descricao não pode ultrapassar :max caracteres',
        ];
    }
}
