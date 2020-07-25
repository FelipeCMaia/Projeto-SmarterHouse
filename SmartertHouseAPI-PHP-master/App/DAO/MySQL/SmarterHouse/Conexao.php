<?php

//Declara uma namespace com o caminho da pasta
namespace App\DAO\MySQL\SmarterHouse;

//cria uma classe abstrata para ser herdada por outros arquivos DAO da pasta
abstract class Conexao
{
    //cria uma variável protegida que será usada para executar as querys
    protected $pdo;

    /*cria um construtor da classe que pega as Constantes
     localizadas no arquivo env.php e executa a conexão com o banco de dados*/
    public function __construct()
    {
        //passa os valores Constantes para as variáveis responsáveis pela conexão
        $host = getenv("SMARTER_MYSQL_HOST");
        $dbname = getenv("SMARTER_MYSQL_DBNAME");
        $user = getenv("SMARTER_MYSQL_USER");
        $pass = getenv("SMARTER_MYSQL_PASSWORD");
        $port = getenv("SMARTER_MYSQL_PORT");

        //declara a query para conexão 
        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        //declara um nova Conexão com o banco de dados
        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->exec("SET NAMES 'utf8';");
        //seta Atriibutos para exceções de erro de conexão
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}
