<?php

declare(strict_types=1);

final class ConexaoBanco
{
    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function obterConexao(string $arquivo): PDO
    {
        if (self::$instancia === null) {
            self::$instancia = self::criarConexao($arquivo);
        }

        return self::$instancia;
    }

    private static function criarConexao(string $arquivo): PDO
    {
        $config = self::carregarConfiguracao($arquivo);
        $dsn = self::montarDsn($config);

        return new PDO($dsn, $config['db_user'], $config['db_password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ]);
    }

    private static function carregarConfiguracao(string $arquivo): array
    {
        $config = parse_ini_file($arquivo, true);

        if ($config === false || !isset($config['development'])) {
            throw new RuntimeException('Configuração do banco inválida.');
        }

        return $config['development'];
    }

    private static function montarDsn(array $config): string
    {
        return sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $config['db_host'],
            $config['db_port'],
            $config['db_name']
        );
    }

    private function __clone(): void
    {
        throw new LogicException('Clonagem não permitida.');
    }

    public function __wakeup(): void
    {
        throw new LogicException('Desserialização não permitida.');
    }
}
