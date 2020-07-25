<?php 

//iniciando o Controller Usuario a namespace Controllers
namespace App\Controllers;

//chamando classes para serem usadas

use App\DAO\MySQL\SmarterHouse\UsuariosDAO;
use App\Exceptions\CustomException;
use App\Models\MySQL\SmarterHouse\UsuarioModel;
use Exception;
use PDOException;
use Psr\Http\Message\{
    RequestInterface as Request,
    ResponseInterface as Response
};

//classe de Usuario 
final class UsuarioController
{
    public function DeletaUsuario(Request $request, Response $response, array $args):Response{
       

       try {
           
           $usuarioDAO = new UsuariosDAO();
           $var = $usuarioDAO->UsuarioExiste($args["id_usuario"]);
           if(!$var){
                throw new CustomException("Usuario Inexistente na base de Dados ",400);
           }
           $usuarioDAO->DeletaUsuario($args["id_usuario"]);
           
           
           $response = $response->withJson(["msg"=>"Deletado com sucesso"]);
           return $response->withJson([
               "error" => "Nenhum Erro Encontrado",
               "status" => 200,
               "code" => 000,
               "user_message" => "Usuario Deletado com Sucesso",
               "developer_message" => "Nenhum Erro Encontrado",
           ], 200);

       }
       catch ( CustomException $ex) {
        return $response->withJson([
            "error" => \CustomException::class,
            "status" => 400,
            "code" => 16,
            "user_message" => "Usuario não existe na base de dados",
            "developer_message" => $ex->getMessage(),
        ], 400);
    }
       catch ( PDOException $ex) {
        return $response->withJson([
            "error" => \PDOException::class,
            "status" => 400,
            "code" => 13,
            "user_message" => "Não foi possivel Remover Usuário",
            "developer_message" => $ex->getMessage(),
        ], 400);
    }
       catch (Exception $th) {
        return $response->withJson([
            "error" => \Exception::class,
            "status" => 500,
            "code" => 015,
            "user_message" => "Erro Inseperado ao deletar Usuario",
            "developer_message" => $ex->getMessage(),
        ], 400);
       }
    }
    public function AtualizaUsuario(Request $request, Response $response, array $args):Response{
        
        try {
            
            $data =$request->getParsedBody();
            $usuarioModel = new UsuarioModel();
            $usuarioDAO = new UsuariosDAO();
            $usuarioModel
            ->setEmail(strtolower($data['login_user']))
            ->setSenha($data['senha_user'])
            ->setNome(strtolower($data['nome_user']))
            ->setId($data['id_user']);

            $usuarioDAO->AtualizaUsuario($usuarioModel);

            $response = $response->withJson(["msg"=>"Atualizado com sucesso"]);
            return $response->withJson([
                "error" => "Nenhum Erro Encontrado",
                "status" => 200,
                "code" => 000,
                "user_message" => "Usuario Atualizado com Sucesso",
                "developer_message" => "Nenhum Erro Encontrado",
            ], 200);
        }
        catch ( PDOException $ex) {
            return $response->withJson([
                "error" => \PDOException::class,
                "status" => 400,
                "code" => 004,
                "user_message" => "Email já existe",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
        catch (\Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 014,
                "user_message" => "Um ou mais valores faltando no corpo da requisição",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
        catch (Exception $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 012,
                "user_message" => "Erro Inseperado ao Atualizar Usuario",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }

        return $response;
    }

    public function SelecionaUsuario(Request $request, Response $response, array $args):Response{
       
       try {
           
           $usuarioModel = new UsuarioModel();
           $usuarioDAO = new UsuariosDAO();
           $array = array();

           $array= $usuarioDAO->SelecionaUsuario($args["id_usuario"],$usuarioModel);
           if(count($array)==0){
            throw new CustomException("Nenhum Usuario Encontrado",400);
           }
   
           $response = $response->withJson($array);
           return $response;

       } catch ( CustomException $ex) {
        return $response->withJson([
            "error" => \CustomException::class,
            "status" => 400,
            "code" => 16,
            "user_message" => "Nenhum usuário encontrado",
            "developer_message" => $ex->getMessage(),
        ], 400);
    }catch ( PDOException $ex) {
            return $response->withJson([
                "error" => \PDOException::class,
                "status" => 400,
                "code" => 17,
                "user_message" => "Falha ao Selecionar o Usuario ",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
        catch (\Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 19,
                "user_message" => "Entrada incorreta no corpo da requisição",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
        catch (Exception $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 18,
                "user_message" => "Erro Inseperado ao Selecionar Usuarios",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }

    }
    
} 