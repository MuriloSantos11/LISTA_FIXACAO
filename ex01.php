<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

function testarConexao(): void
{
    try {
        $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
        $versao = obterVersaoPostgres($pdo);

        echo "Porta 5432 e banco acessíveis.\n";
        echo "PostgreSQL: {$versao}\n";
    } catch (PDOException $e) {
        echo "Falha na conexão com o PostgreSQL.\n";
    }
}

function obterVersaoPostgres(PDO $pdo): string
{
    $consulta = $pdo->query('SELECT version()');
    $resultado = $consulta->fetch();

    return $resultado['version'] ?? 'Versão indisponível';
}

testarConexao();
