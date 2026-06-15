<form method="POST" action="{{ $action }}">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    @include('cargo._form', ['cargo' => $cargo])

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('cargo.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">{{ $botao ?? 'Salvar' }}</button>
        </div>
    </div>
</form>
