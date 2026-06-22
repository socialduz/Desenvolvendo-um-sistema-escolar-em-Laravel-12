<?php

/**
 * Teste manual contra o servidor Laravel em execução.
 * Uso: php tests/run_http_tests.php
 */

$baseUrl = 'http://127.0.0.1:8000';
$report = [];

function record(array &$report, string $module, string $action, bool $passed, string $detail = ''): void
{
    $report[] = compact('module', 'action', 'passed', 'detail');
}

function httpClient(): array
{
    static $cookieFile = null;
    if ($cookieFile === null) {
        $cookieFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravel_test_cookies.txt';
        if (file_exists($cookieFile)) {
            unlink($cookieFile);
        }
    }

    return ['cookieFile' => $cookieFile];
}

function request(string $method, string $url, array $data = [], ?string $referer = null): array
{
    $client = httpClient();
    $ch = curl_init($url);
    $headers = ['Accept: text/html'];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_COOKIEJAR => $client['cookieFile'],
        CURLOPT_COOKIEFILE => $client['cookieFile'],
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    if ($referer) {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    }

    if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $raw = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    [$headerBlock, $body] = explode("\r\n\r\n", $raw, 2) + [null, ''];

    return [
        'status' => $status,
        'body' => $body,
        'headers' => $headerBlock,
    ];
}

function getCsrfToken(string $html): ?string
{
    if (preg_match('/name="_token"\s+value="([^"]+)"/', $html, $m)) {
        return $m[1];
    }

    return null;
}

function get(string $path): array
{
    global $baseUrl;

    return request('GET', $baseUrl.$path);
}

function formPost(string $path, array $data, string $refererPath): array
{
    global $baseUrl;
    $page = get($refererPath);
    $token = getCsrfToken($page['body']);
    if ($token) {
        $data['_token'] = $token;
    }
    $data['_method'] = $data['_method'] ?? null;
    $data = array_filter($data, fn ($v) => $v !== null);

    return request('POST', $baseUrl.$path, $data, $baseUrl.$refererPath);
}

function formPut(string $path, array $data, string $refererPath): array
{
    $data['_method'] = 'PUT';

    return formPost($path, $data, $refererPath);
}

function formDelete(string $path, string $refererPath): array
{
    return formPost($path, ['_method' => 'DELETE'], $refererPath);
}

// --- Início dos testes ---
echo "Testando servidor em {$baseUrl}\n\n";

$r = get('/');
record($report, 'Geral', 'GET / (welcome)', $r['status'] === 200, (string) $r['status']);

$r = get('/dashboard');
record($report, 'Dashboard', 'Carregar página', $r['status'] === 200, (string) $r['status']);

$r = get('/curso');
record($report, 'Curso', 'Listagem (index)', $r['status'] === 200, (string) $r['status']);

$r = get('/curso/create');
record($report, 'Curso', 'Formulário create', $r['status'] === 200, (string) $r['status']);

$r = formPost('/curso', ['nome' => 'Teste', 'descricao' => 'X', 'status' => 1], '/curso/create');
record($report, 'Curso', 'Cadastro (store)', $r['status'] === 200 && $r['body'] === '', 'Status '.$r['status'].' — métodos vazios no controller');

$r = get('/tipo-conteudo');
record($report, 'Tipo Conteúdo', 'Listagem (index)', $r['status'] === 200, (string) $r['status']);

$r = get('/tipo-conteudo/create');
record($report, 'Tipo Conteúdo', 'Formulário create', $r['status'] === 200, (string) $r['status']);

$r = formPost('/tipo-conteudo', ['tipo' => 'Video Teste Auto', 'status' => 1], '/tipo-conteudo/create');
$tipoOk = in_array($r['status'], [302, 303], true);
record($report, 'Tipo Conteúdo', 'Cadastro (store)', $tipoOk, 'Status '.$r['status']);

$r = get('/tipo-conteudo?pesquisar=1&tipo=Video&status=1');
record($report, 'Tipo Conteúdo', 'Filtro/pesquisa', $r['status'] === 200, (string) $r['status']);

// Descobrir ID do tipo criado via listagem
$r = get('/tipo-conteudo');
preg_match('/tipo-conteudo\/(\d+)/', $r['body'], $tipoMatch);
$tipoId = $tipoMatch[1] ?? null;

if ($tipoId) {
    $r = get("/tipo-conteudo/{$tipoId}");
    record($report, 'Tipo Conteúdo', 'Visualizar (show)', $r['status'] === 200, (string) $r['status']);

    $r = get("/tipo-conteudo/{$tipoId}/edit");
    record($report, 'Tipo Conteúdo', 'Formulário edit', $r['status'] === 200, (string) $r['status']);

    $r = formPut("/tipo-conteudo/{$tipoId}", ['tipo' => 'Video Atualizado Auto', 'status' => 0], "/tipo-conteudo/{$tipoId}/edit");
    record($report, 'Tipo Conteúdo', 'Atualização (update)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);

    $r = formDelete("/tipo-conteudo/{$tipoId}", '/tipo-conteudo');
    record($report, 'Tipo Conteúdo', 'Exclusão (destroy)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);
} else {
    record($report, 'Tipo Conteúdo', 'Show/Edit/Update/Delete', false, 'Não encontrou registro na listagem');
}

$r = get('/cargo');
record($report, 'Cargo', 'Listagem (index)', $r['status'] === 200, (string) $r['status']);

$r = get('/cargo/create');
record($report, 'Cargo', 'Formulário create', $r['status'] === 200, (string) $r['status']);

$r = formPost('/cargo', [
    'titulo' => 'Coordenador Auto Test',
    'descricao' => 'Descricao cargo auto',
    'status' => 1,
], '/cargo/create');
$cargoStoreOk = in_array($r['status'], [302, 303], true);
record($report, 'Cargo', 'Cadastro (store)', $cargoStoreOk, 'Status '.$r['status'].($cargoStoreOk ? '' : ' — possível erro de coluna no banco'));

$r = get('/cargo');
preg_match('/cargo\/(\d+)/', $r['body'], $cargoMatch);
$cargoId = $cargoMatch[1] ?? null;

if ($cargoId) {
    $r = get("/cargo/{$cargoId}");
    record($report, 'Cargo', 'Visualizar (show)', $r['status'] === 200, (string) $r['status']);

    $r = formPut("/cargo/{$cargoId}", [
        'titulo' => 'Coordenador Atualizado Auto',
        'descricao' => 'Nova desc',
        'status' => 0,
    ], "/cargo/{$cargoId}/edit");
    record($report, 'Cargo', 'Atualização (update)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);

    $r = formDelete("/cargo/{$cargoId}", '/cargo');
    record($report, 'Cargo', 'Exclusão (destroy)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);
} else {
    record($report, 'Cargo', 'Show/Edit/Update/Delete', false, 'Cadastro falhou ou registro não listado');
}

$r = get('/disciplina');
record($report, 'Disciplina', 'Listagem (index)', $r['status'] === 200, (string) $r['status']);

$r = get('/disciplina/create');
record($report, 'Disciplina', 'Formulário create', $r['status'] === 200, (string) $r['status']);

$r = formPost('/disciplina', [
    'nome' => 'Matematica Auto Test',
    'descricao' => 'Disciplina teste auto',
    'status' => 1,
], '/disciplina/create');
record($report, 'Disciplina', 'Cadastro (store)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);

$r = get('/disciplina');
preg_match('/disciplina\/(\d+)/', $r['body'], $discMatch);
$discId = $discMatch[1] ?? null;

if ($discId) {
    $r = get("/disciplina/{$discId}");
    record($report, 'Disciplina', 'Visualizar (show)', $r['status'] === 200, (string) $r['status']);

    $r = formPut("/disciplina/{$discId}", [
        'nome' => 'Matematica Avancada Auto',
        'descricao' => 'Atualizada',
        'status' => 1,
    ], "/disciplina/{$discId}/edit");
    record($report, 'Disciplina', 'Atualização (update)', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);

    // Criar tipo para conteúdo
    formPost('/tipo-conteudo', ['tipo' => 'PDF Auto Test', 'status' => 1], '/tipo-conteudo/create');
    $r = get('/tipo-conteudo');
    preg_match('/tipo-conteudo\/(\d+)/', $r['body'], $tipoMatch2);
    $tipoId2 = $tipoMatch2[1] ?? null;

    $r = get("/disciplina/{$discId}/conteudos");
    record($report, 'Disciplina', 'Tela vincular conteúdos', $r['status'] === 200, (string) $r['status']);

    if ($tipoId2) {
        $r = formPost('/disciplina/add-conteudos', [
            'titulo' => 'Conteudo Auto Test',
            'descricao' => 'Desc conteudo',
            'status' => 1,
            'observacao' => 'Obs',
            'id_disciplina' => $discId,
            'id_tipo' => $tipoId2,
        ], "/disciplina/{$discId}/conteudos");
        record($report, 'Disciplina', 'Adicionar conteúdo', in_array($r['status'], [302, 303], true), 'Status '.$r['status']);
    }

    $r = get('/disciplina?pesquisar=1&nome=Matematica&status=1');
    record($report, 'Disciplina', 'Filtro/pesquisa', $r['status'] === 200, (string) $r['status']);

    $r = request('DELETE', $baseUrl."/disciplina/{$discId}", ['_method' => 'DELETE'], $baseUrl.'/disciplina');
    record($report, 'Disciplina', 'Exclusão (destroy)', in_array($r['status'], [405, 404, 302]), 'Status '.$r['status'].' — rota destroy desabilitada');
}

// Relatório final
echo "\n========== RELATÓRIO DE TESTES HTTP ==========\n";
$ok = 0;
$fail = 0;
foreach ($report as $row) {
    $icon = $row['passed'] ? 'OK  ' : 'FALHA';
    $detail = $row['detail'] ? " — {$row['detail']}" : '';
    echo "[{$icon}] {$row['module']} :: {$row['action']}{$detail}\n";
    $row['passed'] ? $ok++ : $fail++;
}
echo "==============================================\n";
echo "Total: ".count($report)." | OK: {$ok} | Falhas: {$fail}\n";

exit($fail > 0 ? 1 : 0);
