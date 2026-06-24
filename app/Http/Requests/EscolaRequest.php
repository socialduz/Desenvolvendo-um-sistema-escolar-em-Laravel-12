<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EscolaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_escola' => ['required', 'string', 'max:20'],
            'cnpj' => ['required', 'string', 'max:20'],
            'data_inauguracao' => ['required', 'date'],
            'status' => ['required', 'integer', 'in:0,1'],
            'nome_fantasia' => ['required', 'string', 'max:200'],
            'razao_social' => ['required', 'string', 'max:200'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco' => ['required', 'string'],
            'complemento' => ['nullable', 'string'],
            'bairro' => ['required', 'string', 'max:100'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'max:100'],
            'observacao' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_escola.required' => 'O código da escola é obrigatório.',
            'codigo_escola.max' => 'O código da escola não pode ter mais de 20 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.max' => 'O CNPJ não pode ter mais de 20 caracteres.',
            'data_inauguracao.required' => 'A data de inauguração é obrigatória.',
            'data_inauguracao.date' => 'Informe uma data de inauguração válida.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser Ativo ou Inativo.',
            'nome_fantasia.required' => 'O nome fantasia é obrigatório.',
            'nome_fantasia.max' => 'O nome fantasia não pode ter mais de 200 caracteres.',
            'razao_social.required' => 'A razão social é obrigatória.',
            'razao_social.max' => 'A razão social não pode ter mais de 200 caracteres.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'endereco.required' => 'O endereço é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'bairro.max' => 'O bairro não pode ter mais de 100 caracteres.',
            'cidade.required' => 'A cidade é obrigatória.',
            'cidade.max' => 'A cidade não pode ter mais de 100 caracteres.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.max' => 'O estado não pode ter mais de 100 caracteres.',
        ];
    }

    /**
     * @return list<string>
     */
    public static function condicoesCadastro(): array
    {
        return [
            'Código obrigatório (máx. 20 caracteres).',
            'CNPJ obrigatório (máx. 20 caracteres).',
            'Data de inauguração obrigatória.',
            'Status obrigatório (Ativo ou Inativo).',
            'Nome fantasia e razão social obrigatórios (máx. 200 caracteres).',
            'Endereço, bairro, cidade e estado obrigatórios.',
            'Telefone, complemento e observação são opcionais.',
        ];
    }
}
