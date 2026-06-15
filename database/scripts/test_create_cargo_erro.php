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

$app->make('events')->listen('eloquent.creating: App\Models\Cargo', function () {
    throw new RuntimeException('Erro de cadastro simulado para teste.');
});

$create = requestPage($kernel, 'GET', '/cargo/create');
echo 'GET create: '.$create['status'].PHP_EOL;

$dados = [
    '_token' => $create['csrf'],
    'titulo' => 'Cargo Teste Erro',
    'descricao' => 'Descrição de teste para simular falha no cadastro.',
    'status' => '1',
];

$store = requestPage($kernel, 'POST', '/cargo', $dados, $create['cookies']);
echo 'POST store: '.$store['status'].' -> '.$store['location'].PHP_EOL;

$redirectOk = $store['status'] === 302 && str_contains((string) $store['location'], '/cargo/create');
echo $redirectOk ? "Redirect para cadastro: OK\n" : "Redirect para cadastro: FALHOU\n";

$createAfterError = requestPage($kernel, 'GET', (string) $store['location'], [], $store['cookies']);
$body = $createAfterError['body'];

$alertaOk = str_contains($body, 'Não foi possível cadastrar o cargo');
echo $alertaOk ? "Alerta de erro exibido: OK\n" : "Alerta de erro exibido: FALHOU\n";

$inputOk = str_contains($body, 'Cargo Teste Erro')
    && str_contains($body, 'Descrição de teste para simular falha no cadastro');
echo $inputOk ? "Campos repreenchidos: OK\n" : "Campos repreenchidos: FALHOU\n";

$row = App\Models\Cargo::query()->where('titulo', 'Cargo Teste Erro')->first();
echo $row ? "DB: registro NÃO deveria existir (FALHOU)\n" : "DB: registro não criado (OK)\n";
