<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
/** @var Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Http\Request;

$user = User::query()->first();
$admin = Administrativo::query()->first();

$session = $app['session.store'];
$session->start();
$session->put('_token', 'test');
$session->put('login_web_'.sha1('Illuminate\Auth\SessionGuard'), $user->getAuthIdentifier());

$request = Request::create("/administrativo/{$admin->id}/edit", 'GET');
$request->setLaravelSession($session);
$request->cookies->set($session->getName(), $session->getId());

$response = $kernel->handle($request);
$html = $response->getContent();
$status = $response->getStatusCode();

echo "HTTP {$status}\n";

if ($status !== 200) {
    echo substr($html, 0, 500) . "\n";
    exit(1);
}

$hasCargoLabel = str_contains($html, 'edit_id_cargo') || str_contains($html, 'for="id_cargo"');
$hasCargoSelect = str_contains($html, 'name="id_cargo"');
preg_match('/name="id_cargo"[^>]*>(.*?)<\/select>/s', $html, $m);
$optionCount = isset($m[1]) ? preg_match_all('/<option[^>]+value="\d+"/', $m[1]) : 0;
$hasDiretor = str_contains($html, 'Diretor');
$hasSelected = str_contains($html, 'selected');

echo "Cargo label/select: " . ($hasCargoLabel && $hasCargoSelect ? 'SIM' : 'NAO') . "\n";
echo "Opcoes de cargo: {$optionCount}\n";
echo "Contem Diretor: " . ($hasDiretor ? 'SIM' : 'NAO') . "\n";
echo "Tem selected: " . ($hasSelected ? 'SIM' : 'NAO') . "\n";

// extract cargo select snippet
if (preg_match('/<select[^>]*name="id_cargo"[^>]*>.*?<\/select>/s', $html, $select)) {
    echo "\n--- SELECT CARGO (primeiros 800 chars) ---\n";
    echo substr($select[0], 0, 800) . "\n";
}

$kernel->terminate($request, $response);
