<?php

declare(strict_types=1);

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

function carregarAmbiente(string $ambiente): array
{
    $config = parse_ini_file(ARQUIVO_CONFIG, true);

    if ($config === false || !isset($config[$ambiente])) {
        throw new RuntimeException('Ambiente não encontrado.');
    }

    return $config[$ambiente];
}

function criarConexaoAmbiente(string $ambiente): PDO
{
    $config = carregarAmbiente($ambiente);
    $dsn = montarDsn($config);

    return new PDO($dsn, $config['db_user'], $config['db_password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false,
    ]);
}

function montarDsn(array $config): string
{
    return sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $config['db_host'],
        $config['db_port'],
        $config['db_name']
    );
}

function executarTeste(string $ambiente): void
{
    try {
        $pdo = criarConexaoAmbiente($ambiente);
        $pdo->query('SELECT 1');

        echo "Ambiente {$ambiente}: conexão OK.\n";
    } catch (PDOException $e) {
        echo "Ambiente {$ambiente}: falha na conexão.\n";
    }
}

executarTeste('development');
executarTeste('testing');
