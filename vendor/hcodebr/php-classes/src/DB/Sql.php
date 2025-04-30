<?php

namespace Hcode\DB; // Define o namespace para organização do código e evitar conflitos de nomes

class Sql {

    const HOSTNAME = "127.0.0.1";       // Endereço do servidor MySQL
    const USERNAME = "root";            // Nome de usuário do banco de dados
    const PASSWORD = "Desenv#6";        // Senha do banco de dados
    const DBNAME = "db_ecommerce2";     // Nome do banco de dados a ser utilizado

    private $conn; // Propriedade privada que armazenará a conexão PDO

    public function __construct() // Método construtor, executado automaticamente ao instanciar a classe
    {
        // Cria uma nova conexão PDO com o banco de dados MySQL usando os dados fornecidos acima
        $this->conn = new \PDO(
            "mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, // DSN: define o nome do banco e host
            Sql::USERNAME,  // Nome do usuário
            Sql::PASSWORD   // Senha
        );
    }

    private function setParams($statement, $parameters = array()) // Define os parâmetros em uma query preparada
    {
        foreach ($parameters as $key => $value) {
            // Para cada parâmetro, chama o método bindParam para associar valor à chave
            $this->bindParam($statement, $key, $value);
        }
    }

    private function bindParam($statement, $key, $value) // Associa um valor a um marcador de parâmetro na SQL
    {
        $statement->bindParam($key, $value); // Ex: :LOGIN => 'admin'
    }

    public function query($rawQuery, $params = array()) // Executa uma instrução SQL sem retorno (INSERT, UPDATE, DELETE)
    {
        $stmt = $this->conn->prepare($rawQuery); // Prepara a query
        $this->setParams($stmt, $params);        // Define os parâmetros, se houver
        $stmt->execute();                        // Executa a query
    }

    public function select($rawQuery, $params = array()):array // Executa uma SELECT e retorna os dados em array
    {
        $stmt = $this->conn->prepare($rawQuery); // Prepara a query
        $this->setParams($stmt, $params);        // Define os parâmetros
        $stmt->execute();                        // Executa a query

        // Retorna todos os resultados como array associativo
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
