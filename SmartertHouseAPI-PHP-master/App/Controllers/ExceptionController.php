<?php

//declarando o Controller Exception para a namespace Controller
namespace App\Controllers;

//usando diretórios para utilização de classes
use App\Exceptions\CustomException;
use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};

//classe para Exceções de erro
final class ExceptionController
{
    //função para Exceção das exeções na rota exception-test
    public function exception(Request $request, Response $response, array $args): Response
    {
        //decalrando try Catch para lançmanto de exceções
        try {
            //forçando uma exceção para teste
            throw new CustomException("Testando mensagem teste de erro");
            return $response->withjson([
                "msg" => "ok"
            ]);
        }
        //caso de occorência de exceção Customizada
        catch (CustomException $ex) {
            //retornando a responsta em Json
            return $response->withJson([
                "error" => CustomException::class,
                "status" => 400,
                "code" => 003,
                "user_message" => "Testando",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } 
        //capturando as exceções
        catch (\InvalidArgumentException $ex) {
            return $response->withJson([
                "error" => \InvalidArgumentException::class,
                "status" => 400,
                "code" => 002,
                "user_message" => "Argumento incorreto passado",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } 
        /*a Exception deve sempre estar no final, 
        pois todas as outras exceções herdam de exception*/
        catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 001,
                "user_message" => "Um erro de conexão impede o servidor de reponder",
                "developer_message" => $ex->getMessage(),
            ], 500);
        }
    }
}
