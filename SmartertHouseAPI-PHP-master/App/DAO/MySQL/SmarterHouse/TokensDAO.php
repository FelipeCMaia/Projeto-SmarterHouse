<?php

namespace App\DAO\MySQL\SmarterHouse;

//Usa o modelo do Tipo Token localizado na Pasta Models
use App\Models\MySQL\SmarterHouse\TokenModel;

class TokensDAO extends Conexao
{

    //cria o contrutor e chama-o
    public function __construct()
    {
        parent::__construct();
    }

    /*Insere um novo Token na base de Dados a partir de um Token
     criado passado por parãmetro*/
    public function createToken(TokenModel $token): void
    {
        //prepara a query
        $statement = $this->pdo
            ->prepare(
                'INSERT INTO  tbl_tokens 
            (
                token,
                refresh_token,
                expired_at,
                ID_USER,
                active
            )
            VALUES
            (
                :token,
                :refresh_token,
                :expired_at,
                :ID_USER,
                :active
            )
            '
            );

        /*executa a query passando os parâmetos pegando 
            do parãmetro Token que está sendo passado*/
        $statement->execute([
            'token' => $token->getToken(),
            'refresh_token' => $token->getRefresh_token(),
            'expired_at' => $token->getExpired_at(),
            'ID_USER' => $token->getUsuarios_id(),
            'active' => $token->getActive()
        ]);
    }

    /*método que verifica se o refreshToken existe no banco de dados,
    retorna um valor booleano*/
    public function verifyRefreshToken(string $refreshToken): bool
    {
        //prepara a query
        $statement = $this->pdo->prepare(
            'SELECT 
            ID_USER
            FROM tbl_tokens
            WHERE refresh_token = :refresh_token AND active = 1'
        );
        //passa o valor do refreshtoken para a variável statement
        $statement->bindParam('refresh_token', $refreshToken);
        //executa a query
        $statement->execute();
        //passa o valor da consula para um array 
        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);

        //verifica o tamanho do array e retorna true = 0 ou false > 0 
        return count($tokens) === 0 ? false : true;
    }

    public function DisableExpiredToken(string $expiredAt)
    {

        $removeexpiredToken = $this->pdo
            ->prepare('UPDATE tbl_tokens SET active = 0 WHERE expired_at = :expired_at');
        $removeexpiredToken->bindParam('expired_at', $expiredAt);
        $removeexpiredToken->execute();

        //====DELETE====
        // $removeexpiredToken= $this->pdo
        //     ->prepare('DELETE FROM tokens WHERE expired_at = :expired_at');
        // $removeexpiredToken->bindParam('expired_at',$expiredAt);
        // $removeexpiredToken->execute();
    }
}
