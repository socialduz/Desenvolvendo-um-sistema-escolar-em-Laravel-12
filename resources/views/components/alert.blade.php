@if (! empty($alerta))
<div class="alert alert-{{ $alerta['tipo'] ?? 'info' }} alert-dismissible fade show" role="alert">
    {{ $alerta['mensagem'] }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
