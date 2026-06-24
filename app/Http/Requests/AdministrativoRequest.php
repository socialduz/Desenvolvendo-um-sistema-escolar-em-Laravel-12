<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministrativoRequest extends FormRequest
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
            'id_cargo' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'O usuário é obrigatório.',
            'id_escola.required' => 'A escola é obrigatória.',
            'id_cargo.required' => 'O cargo é obrigatório.',
        ];
    }
}