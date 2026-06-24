<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Administrativo;
use App\Models\User;

$user = User::query()->first();
$admin = Administrativo::query()->first();

$session = $app['session.store'];
$session->start();
$session->put('login_web_'.sha1('Illuminate\Auth\SessionGuard'), $user->getAuthIdentifier());

$request = Illuminate\Http\Request::create("/administrativo/{$admin->id}", 'GET');
$request->setLaravelSession($session);
$request->cookies->set($session->getName(), $session->getId());

$response = $kernel->handle($request);
$html = $response->getContent();

echo "HTTP {$response->getStatusCode()}\n";
echo "Tem Cargo: " . (str_contains($html, 'Diretor') ? 'SIM' : 'NAO') . "\n";
echo "Tamanho HTML: " . strlen($html) . " bytes\n";

$kernel->terminate($request, $response);
