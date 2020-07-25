<?php

namespace App\Middlewares;

use App\DAO\MySQL\SmarterHouse\TokensDAO;
use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};

//classe para a execução da verificação de expiração do token
final class JwtDateMiddleware
{
    //chama um método invoke que é executado com a chamada da classe 
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        //pega os dados contidos no atributo jwt
        $token = $request->getAttribute('jwt');
        //pega o valor do token epired_at contido em jwt
        $expiredDate = new \DateTime($token['expired_at'], new \DateTimeZone('America/Sao_Paulo'));
        
        //pega a data Atual
        $now = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        
        //verifica se a Data Atual é menor que a data de expiração do token
         //retorna status 401 de erro
        if ($expiredDate < $now){
            $expiredToken = new TokensDAO();
            $expiredToken->DisableExpiredToken(strval($token['expired_at']));
            return $response->withJson([
                "status" => 401,
                "code" => 8,
                "user_message" => "Token de acesso Expirado",
                "developer_message" => 'O Token de acesso foi expirado, crie um novo Token poder requisitar esta função',
            ], 401);
        }
        //retorna chamada do próximo middleware na hierarquia
        $response = $next($request, $response);
        return $response;
    }
}
