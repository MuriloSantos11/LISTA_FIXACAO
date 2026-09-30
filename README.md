## PDO: É uma interface do PHP para acessar bancos de dados. É preferível ao pgsql porque é padronizado, seguro e facilita trabalhar com diferentes SGBDs.

## DSN: É a string que informa os dados da conexão.

## host: endereço do servidor.

## port: porta do banco.

## dbname: nome do banco.

## Porta padrão: O PostgreSQL usa a porta 5432, indicada assim:

## port=5432

## ERRMODE_EXCEPTION: Faz o PDO lançar exceções quando ocorre um erro. Sem configurar, o padrão é ERRMODE_SILENT.

## FETCH_ASSOC: Retorna apenas índices associativos, evitando duplicação de dados e economizando memória.

## Singleton: Evita criar várias conexões com new PDO(), reduzindo o risco de atingir o limite max_connections.

## Construtor privado: Impede que outras partes criem novas instâncias. Também se bloqueia __clone() para evitar cópias.

## Credenciais: Usuário e senha não devem ficar no código porque podem ser expostos. O ideal é usar variáveis de ambiente ou gerenciadores de segredos.

## $e->getMessage(): Não deve ser mostrado ao usuário porque pode revelar informações do banco e do servidor. O erro deve ir para logs, enquanto o usuário recebe uma mensagem genérica.



