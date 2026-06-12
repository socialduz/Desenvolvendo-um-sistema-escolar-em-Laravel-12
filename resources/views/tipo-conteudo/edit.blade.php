<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('tipo-conteudo._cabecalho', ['titulo' => 'Editar Tipo'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('tipo-conteudo._formulario', [
                    'action' => route('tipo-conteudo.update', $tipoConteudo),
                    'method' => 'PUT',
                    'botao' => 'Salvar alterações',
                    'tipoConteudo' => $tipoConteudo,
                ])
            </div>
        </div>
    </div>

</x-layout>
