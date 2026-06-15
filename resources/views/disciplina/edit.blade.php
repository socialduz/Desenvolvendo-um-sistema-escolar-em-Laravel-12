<x-layout>

    <div class="container-fluid">
        <div class="row">
            @include('disciplina._cabecalho', ['titulo' => 'Editar Disciplina'])

            <div class="col-12 my-5">
                <x-alert :alerta="$alerta ?? null" />

                @include('disciplina._formulario', [
                    'action' => route('disciplina.update', $disciplina),
                    'method' => 'PUT',
                    'botao' => 'Salvar alterações',
                    'disciplina' => $disciplina,
                ])
            </div>
        </div>
    </div>

</x-layout>
