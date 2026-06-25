<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfessorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => ['required', 'integer'],
            'id_escola' => ['required', 'integer'],
            'registro' => ['required', 'string', 'max:20'],
            'salario' => ['required', 'numeric'],
            // status, telefone e observacao: opcionais (como na aula)
            // data_cadastro: NÃO entra aqui — vai no store() no Passo 3
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'O professor é obrigatório.',
            'id_escola.required' => 'A escola é obrigatória.',
            'registro.required' => 'O registro é obrigatório.',
            'salario.required' => 'O salário é obrigatório.',
            'salario.numeric' => 'O salário deve ser um valor numérico.',
        ];
    }
}