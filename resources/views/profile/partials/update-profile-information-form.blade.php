<section>
    <h5 class="font-weight-bold text-primary mb-1">Informações do perfil</h5>
    <p class="text-muted small mb-4">Atualize seu nome e endereço de e-mail.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-group mb-0">
                    <label class="d-block" for="name">Nome <span class="text-danger">*</span></label>
                    <input
                        class="form-control @error('name') is-invalid @enderror"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        maxlength="255"
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-8">
                <div class="form-group mb-0">
                    <label class="d-block" for="email">E-mail <span class="text-danger">*</span></label>
                    <input
                        class="form-control @error('email') is-invalid @enderror"
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        maxlength="255"
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <p class="small text-muted mt-2 mb-0">
                            Seu e-mail ainda não foi verificado.
                            <button form="send-verification" type="submit" class="btn btn-link btn-sm p-0 align-baseline">
                                Clique aqui para reenviar o e-mail de verificação.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="small text-success mt-2 mb-0">
                                Um novo link de verificação foi enviado para seu e-mail.
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
    </form>
</section>
