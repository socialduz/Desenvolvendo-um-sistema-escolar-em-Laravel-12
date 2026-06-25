<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'id_escola' => ['required', 'integer'],
            'nome' => ['required', 'string', 'max:100'],
            'descricao' => ['required', 'string', 'max:200'],
            // id_professor, dt_inicio, dt_termino, status, observacao: Passo 3
        ];
    }
    
    public function messages(): array
    {
        return [
            'id_escola.required' => 'A escola é obrigatória.',
            'nome.required' => 'O código é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
        ];
    }
    
     
    
}
