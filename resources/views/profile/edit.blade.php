<x-layout>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-end border-bottom border-secondary py-3">
                <h3 class="my-0"><span class="font-weight-bold">Perfil</span> - Meu Perfil</h3>
                <a class="btn btn-primary" href="{{ route('dashboard') }}">Voltar</a>
            </div>

            <div class="col-12 col-lg-8 my-4">
                <x-alert :alerta="$alerta ?? null" />

                <div class="card shadow mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card shadow mb-4 border-left-danger">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
