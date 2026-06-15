<form method="POST" action="{{ $action }}">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    @include('disciplina._form', ['disciplina' => $disciplina])

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('disciplina.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">{{ $botao ?? 'Salvar' }}</button>
        </div>
    </div>
</form>
