<section>
    <h5 class="font-weight-bold text-danger mb-1">Excluir conta</h5>
    <p class="text-muted small mb-4">
        Ao excluir sua conta, todos os dados serão removidos permanentemente.
        Confirme sua senha antes de continuar.
    </p>

    <button
        type="button"
        class="btn btn-danger"
        data-toggle="modal"
        data-target="#deleteAccountModal"
    >
        Excluir conta
    </button>
</section>

<div
    class="modal fade @if($errors->userDeletion->isNotEmpty()) show @endif"
    id="deleteAccountModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="deleteAccountModalLabel"
    aria-hidden="@if($errors->userDeletion->isNotEmpty()) false @else true @endif"
    @if($errors->userDeletion->isNotEmpty()) style="display: block;" @endif
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar exclusão da conta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Esta ação não pode ser desfeita. Digite sua senha para confirmar a exclusão permanente da conta.
                    </p>

                    <div class="form-group mb-0">
                        <label class="d-block" for="password">Senha <span class="text-danger">*</span></label>
                        <input
                            class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                        >
                        @if ($errors->userDeletion->has('password'))
                            <div class="invalid-feedback d-block">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir conta</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <div class="modal-backdrop fade show"></div>
@endif
