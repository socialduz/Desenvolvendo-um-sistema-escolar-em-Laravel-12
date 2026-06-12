<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('tipo-conteudo._cabecalho', ['titulo' => 'Cadastrar Tipo'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('tipo-conteudo._condicoes_cadastro')

                @include('tipo-conteudo._formulario', [
                    'action' => route('tipo-conteudo.store'),
                    'botao' => 'Salvar',
                    'tipoConteudo' => $tipoConteudo,
                ])
            </div>
        </div>
    </div>

</x-layout>
