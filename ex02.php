<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

function testarIdentidade(): void
{
    try {
        $conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
        $conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

        exibirResultado($conexao1, $conexao2);
    } catch (PDOException $e) {
        echo "Não foi possível testar o Singleton.\n";
    }
}

function exibirResultado(PDO $conexao1, PDO $conexao2): void
{
    $mesmaInstancia = $conexao1 === $conexao2;

    echo 'Objeto 1: ' . spl_object_id($conexao1) . PHP_EOL;
    echo 'Objeto 2: ' . spl_object_id($conexao2) . PHP_EOL;
    echo $mesmaInstancia
        ? "Singleton funcionando.\n"
        : "Foram criadas instâncias diferentes.\n";
}

testarIdentidade();
