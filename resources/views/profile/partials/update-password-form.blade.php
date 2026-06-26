<section>
    <h5 class="font-weight-bold text-primary mb-1">Alterar senha</h5>
    <p class="text-muted small mb-4">Use uma senha longa e segura para proteger sua conta.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="form-group mb-0">
                    <label class="d-block" for="update_password_current_password">Senha atual <span class="text-danger">*</span></label>
                    <input
                        class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                        type="password"
                        name="current_password"
                        id="update_password_current_password"
                        autocomplete="current-password"
                    >
                    @if ($errors->updatePassword->has('current_password'))
                        <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('current_password') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="form-group mb-0">
                    <label class="d-block" for="update_password_password">Nova senha <span class="text-danger">*</span></label>
                    <input
                        class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
                        type="password"
                        name="password"
                        id="update_password_password"
                        autocomplete="new-password"
                    >
                    @if ($errors->updatePassword->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('password') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group mb-0">
                    <label class="d-block" for="update_password_password_confirmation">Confirmar nova senha <span class="text-danger">*</span></label>
                    <input
                        class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                        type="password"
                        name="password_confirmation"
                        id="update_password_password_confirmation"
                        autocomplete="new-password"
                    >
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Salvar senha</button>
        </div>
    </form>
</section>
