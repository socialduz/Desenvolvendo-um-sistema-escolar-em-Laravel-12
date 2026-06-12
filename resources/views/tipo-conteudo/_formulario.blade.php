<form method="POST" action="{{ $action }}">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    @include('tipo-conteudo._form')

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('tipo-conteudo.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">{{ $botao ?? 'Salvar' }}</button>
        </div>
    </div>
</form>
