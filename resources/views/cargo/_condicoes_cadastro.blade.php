<div class="border-left-info bg-light rounded py-2 px-3 mb-3 small">
    <span class="font-weight-bold text-info">Condições para cadastro</span>
    <ul class="mb-0 mt-1 pl-3 text-muted">
        @foreach ($condicoes as $condicao)
            <li class="mb-0">{{ $condicao }}</li>
        @endforeach
    </ul>
</div>
