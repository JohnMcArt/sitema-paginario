<?php
/**
 * Conexão PDO do Paginário.
 * Configure DB_HOST, DB_NAME, DB_USER e DB_PASS no ambiente em vez de salvar credenciais no repositório.
 */
// Carrega um .env local opcional sem depender de bibliotecas externas.
$arquivoEnv = dirname(__DIR__) . '/.env';
if (is_readable($arquivoEnv)) {
    foreach (file($arquivoEnv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linhaEnv) {
        $linhaEnv = trim($linhaEnv);
        if ($linhaEnv === '' || str_starts_with($linhaEnv, '#') || !str_contains($linhaEnv, '=')) {
            continue;
        }
        [$chaveEnv, $valorEnv] = explode('=', $linhaEnv, 2);
        $chaveEnv = trim($chaveEnv);
        $valorEnv = trim(trim($valorEnv), "\"'");
        if ($chaveEnv !== '' && getenv($chaveEnv) === false) {
            putenv($chaveEnv . '=' . $valorEnv);
            $_ENV[$chaveEnv] = $valorEnv;
        }
    }
}

$host = getenv('DB_HOST') ?: '127.0.0.1';
$database = getenv('DB_NAME') ?: 'biblioteca_paginario';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS');
$password = $password === false ? '' : $password;

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $database);

try {
    $conexao = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $erro) {
    error_log('[Paginário] Falha ao conectar ao banco de dados: ' . $erro->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Confira as configurações no README e tente novamente.');
}
