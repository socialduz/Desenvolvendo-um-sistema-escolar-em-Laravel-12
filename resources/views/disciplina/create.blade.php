<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('disciplina._cabecalho', ['titulo' => 'Cadastrar Disciplina'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('disciplina._condicoes_cadastro')

                @include('disciplina._formulario', [
                    'action' => route('disciplina.store'),
                    'botao' => 'Salvar',
                    'disciplina' => $disciplina,
                ])
            </div>
        </div>
    </div>

</x-layout>
