<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('password')) {
            $this->merge(['password' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'rg' => ['required', 'string', 'max:20'],
            'cpf' => ['required', 'string', 'max:20'],
            'status' => ['required', 'integer', 'in:0,1'],
            'endereco' => ['required', 'string'],
            'complemento' => ['nullable', 'string'],
            'bairro' => ['required', 'string', 'max:100'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'max:100'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'observacao' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'rg.required' => 'O RG é obrigatório.',
            'rg.max' => 'O RG não pode ter mais de 20 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.max' => 'O CPF não pode ter mais de 20 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser Ativo ou Inativo.',
            'endereco.required' => 'O endereço é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'bairro.max' => 'O bairro não pode ter mais de 100 caracteres.',
            'cidade.required' => 'A cidade é obrigatória.',
            'cidade.max' => 'A cidade não pode ter mais de 100 caracteres.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.max' => 'O estado não pode ter mais de 100 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
        ];
    }

    /**
     * @return list<string>
     */
    public static function condicoesCadastro(): array
    {
        return [
            'Nome e e-mail obrigatórios.',
            'Senha opcional (preencha apenas para alterar).',
            'RG, CPF e status obrigatórios.',
            'Endereço, bairro, cidade e estado obrigatórios.',
            'Telefone, complemento e observação são opcionais.',
        ];
    }
}
