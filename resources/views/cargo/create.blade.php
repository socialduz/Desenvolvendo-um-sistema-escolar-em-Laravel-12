<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('cargo._cabecalho', ['titulo' => 'Cadastrar Cargo'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('cargo._condicoes_cadastro')

                @include('cargo._formulario', [
                    'action' => route('cargo.store'),
                    'botao' => 'Salvar',
                    'cargo' => $cargo,
                ])
            </div>
        </div>
    </div>

</x-layout>
