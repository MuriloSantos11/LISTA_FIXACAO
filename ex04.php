<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';
const ARQUIVO_LOG = __DIR__ . '/logs/sistema.log';

function registrarLog(string $nivel, string $mensagem): void
{
    $niveis = ['INFO', 'WARNING', 'ERROR'];

    if (!in_array($nivel, $niveis, true)) {
        throw new InvalidArgumentException('Nível de log inválido.');
    }

    $data = date('Y-m-d H:i:s');
    $linha = "[{$data}] [{$nivel}] {$mensagem}" . PHP_EOL;

    file_put_contents(ARQUIVO_LOG, $linha, FILE_APPEND | LOCK_EX);
}

function testarBanco(): void
{
    try {
        ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
        registrarLog('INFO', 'Conexão com PostgreSQL realizada.');
        echo "Conexão realizada com sucesso.\n";
    } catch (PDOException $e) {
        registrarLog('ERROR', $e->getMessage());
        echo "Falha ao conectar ao banco de dados.\n";
    }
}

testarBanco();
