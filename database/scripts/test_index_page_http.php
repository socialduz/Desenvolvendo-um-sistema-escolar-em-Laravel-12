<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;

$user = User::query()->first();
$session = $app['session.store'];
$session->start();
$session->put('login_web_'.sha1('Illuminate\Auth\SessionGuard'), $user->getAuthIdentifier());

$request = Request::create('/administrativo', 'GET');
$request->setLaravelSession($session);
$request->cookies->set($session->getName(), $session->getId());

$response = $kernel->handle($request);
$html = $response->getContent();

echo "HTTP {$response->getStatusCode()}\n";
echo "Header Cargo: " . (str_contains($html, '<th>Cargo</th>') ? 'SIM' : 'NAO') . "\n";
echo "Celula Diretor: " . (str_contains($html, 'Diretor') ? 'SIM' : 'NAO') . "\n";
echo "Filtro id_cargo: " . (str_contains($html, 'name="id_cargo"') ? 'SIM' : 'NAO') . "\n";

preg_match_all('/<td[^>]*>(.*?)<\/td>/s', $html, $cells);
echo "Total celulas td: " . count($cells[1]) . "\n";

$kernel->terminate($request, $response);
