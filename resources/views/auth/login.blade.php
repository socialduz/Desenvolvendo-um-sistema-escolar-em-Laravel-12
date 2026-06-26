<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="font-weight-bold text-gray-700" for="email">E-mail</label>
            <input
                id="email"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="Digite seu e-mail"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="font-weight-bold text-gray-700" for="password">Senha</label>
            <input
                id="password"
                class="form-control form-control-user @error('password') is-invalid @enderror"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Digite sua senha"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    name="remember"
                    id="remember_me"
                >
                <label class="custom-control-label text-gray-700" for="remember_me">Lembrar-me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block py-2">
            Entrar
        </button>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="small text-primary" href="{{ route('password.request') }}">
                    Esqueceu sua senha?
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
