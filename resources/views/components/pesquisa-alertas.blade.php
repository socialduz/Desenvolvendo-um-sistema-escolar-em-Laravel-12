<div class="col-12">
    @if (session('success'))
        <div class="alert alert-success mt-2" role="alert">
            {{ session('success') }}
        </div>
    @endif
</div>

@if (session('error'))
    <div class="alert alert-danger mt-2" role="alert">
        {{ session('error') }}
    </div>
@endif

@if (session('alerta'))
    <div class="col-12">
        <x-alert :alerta="session('alerta')" />
    </div>
@endif
