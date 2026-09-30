<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

function medirSemSingleton(): array
{
    $inicio = microtime(true);
    $memoria = memory_get_usage();

    for ($i = 0; $i < 50; $i++) {
        criarNovaConexao();
    }

    return calcularResultado($inicio, $memoria);
}

function criarNovaConexao(): void
{
    $config = parse_ini_file(ARQUIVO_CONFIG, true);
    $dados = $config['development'];

    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $dados['db_host'],
        $dados['db_port'],
        $dados['db_name']
    );

    $pdo = new PDO($dsn, $dados['db_user'], $dados['db_password']);
    $pdo = null;
}

function medirComSingleton(): array
{
    $inicio = microtime(true);
    $memoria = memory_get_usage();

    for ($i = 0; $i < 50; $i++) {
        ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    }

    return calcularResultado($inicio, $memoria);
}

function calcularResultado(float $inicio, int $memoria): array
{
    return [
        'tempo' => microtime(true) - $inicio,
        'memoria' => memory_get_usage() - $memoria,
    ];
}

function exibirTabela(array $semSingleton, array $singleton): void
{
    echo '<table border="1">';
    echo '<tr><th>Método</th><th>Tempo</th><th>Memória</th></tr>';
    exibirLinha('50 novas conexões', $semSingleton);
    exibirLinha('Singleton', $singleton);
    echo '</table>';
}

function exibirLinha(string $nome, array $resultado): void
{
    printf(
        '<tr><td>%s</td><td>%.6f s</td><td>%d bytes</td></tr>',
        $nome,
        $resultado['tempo'],
        $resultado['memoria']
    );
}

$semSingleton = medirSemSingleton();
$singleton = medirComSingleton();

exibirTabela($semSingleton, $singleton);
