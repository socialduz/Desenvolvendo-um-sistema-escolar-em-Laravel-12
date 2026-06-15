@props(['alerta' => null])

@if (! empty($alerta))
<div class="alert alert-{{ $alerta['tipo'] ?? 'info' }} alert-dismissible fade show" role="alert">
    {{ $alerta['mensagem'] }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $erro)
            <li>{{ $erro }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
