<?php

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

function requestPage($kernel, string $method, string $uri, array $data = [], array $cookies = []): array
{
    $response = $kernel->handle(Illuminate\Http\Request::create($uri, $method, $data, $cookies));

    $newCookies = $cookies;
    foreach ($response->headers->getCookies() as $cookie) {
        $newCookies[$cookie->getName()] = $cookie->getValue();
    }

    preg_match('/name="_token" value="([^"]+)"/', (string) $response->getContent(), $matches);

    return [
        'status' => $response->getStatusCode(),
        'body' => (string) $response->getContent(),
        'cookies' => $newCookies,
        'csrf' => $matches[1] ?? null,
        'location' => $response->headers->get('Location'),
    ];
}

$create = requestPage($kernel, 'GET', '/tipo-conteudo/create');
echo 'GET create: '.$create['status'].PHP_EOL;

$store = requestPage($kernel, 'POST', '/tipo-conteudo', [
    '_token' => $create['csrf'],
    'tipo' => 'Teste Tipo Botao',
    'status' => '1',
], $create['cookies']);

echo 'POST store: '.$store['status'].' -> '.$store['location'].PHP_EOL;

$row = App\Models\TipoConteudo::query()->where('tipo', 'Teste Tipo Botao')->first();
echo $row ? 'DB ok id='.$row->id.PHP_EOL : "DB fail\n";

if ($row) {
    $row->delete();
}
