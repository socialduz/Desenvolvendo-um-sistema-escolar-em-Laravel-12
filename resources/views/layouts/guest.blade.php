<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistema Escolar - Login</title>

        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

        <style>
            body.guest-page {
                min-height: 100vh;
                margin: 0;
                background: linear-gradient(180deg, #a8c8f0 0%, #b8d4f5 45%, #c5ddf8 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            .guest-wrapper {
                width: 100%;
                max-width: 520px;
                padding: 1.5rem;
            }

            .guest-brand i {
                color: #4e73df;
                font-size: 5rem;
            }

            .guest-brand-title {
                margin-top: 0.35rem;
            }

            .guest-card {
                border: 0;
                border-radius: 0.75rem;
            }

            .guest-card .card-body {
                padding: 2.5rem 2.75rem;
            }
        </style>
    </head>
    <body class="guest-page">
        <div class="guest-wrapper">
            <div class="text-center mb-4 guest-brand">
                <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                <h4 class="font-weight-bold text-gray-800 guest-brand-title mb-0">Sistema Escolar</h4>
            </div>

            <div class="card shadow-lg guest-card">
                <div class="card-body">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
