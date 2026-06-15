<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('cargo._cabecalho', ['titulo' => 'Editar Cargo'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('cargo._formulario', [
                    'action' => route('cargo.update', $cargo),
                    'method' => 'PUT',
                    'botao' => 'Salvar alterações',
                    'cargo' => $cargo,
                ])
            </div>
        </div>
    </div>

</x-layout>
