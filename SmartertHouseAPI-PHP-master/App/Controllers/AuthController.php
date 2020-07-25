<?php

//adiciona a classe AuthController a namespace Controller
namespace App\Controllers;

//Faz os usings das classes e dos models necessários 
use App\DAO\MySQL\SmarterHouse\{
    TokensDAO,
    UsuariosDAO
};
use App\Exceptions\CustomException;
use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};
use App\Models\MySQL\SmarterHouse\{
    CasaModel,
    TokenModel,
    UsuarioModel
};
use \Firebase\JWT\JWT;

//declara uma classe para a Autenticação de Token JWT
final class AuthController
{
    //Função que executa o login do usuario no banco de dados
    public function login(Request $request, Response $response, array $args): Response
    {
        try {
            //pega o corpo da requisição 
            $data = $request->getParsedBody();


            //passa o email recebido pela requisição para uma variável
            $email = $data['email'];
            //declara uma nova classe para a comunicação com a base de dados
            $usuariosDAO = new UsuariosDAO;
            //pega as inforamções do usuário no banco de dados se o email informado existir na base de dados
            $usuario = $usuariosDAO->getUserByEmail($email);

            if (is_null($usuario)) {
                throw new CustomException("Email inválido", 002);
                return $response->withStatus(400);
            }
            //verifica se a senha informada pelo usuário é igual a senha contida no banco de dados
            //ou
            //se a variável usuário que recebeu as informações do SELECT no banco de dados está nula
            //caso uma delas for verdade, retorna status 401 de erro

            if (!(md5($data['senha']) == $usuario->getSenha())) {
                throw new CustomException("Senha inválida", 003);
                return $response->withStatus(400);
            }

            //declara uma data de expiração de 2 dias apartir do momento para o token do usuário
            $expired_date = (new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->modify('+2 days')->format('Y-m-d H:i:s');
            $response = $this->CreateToken($response, $usuario, $expired_date);

            return $response;
        } catch (CustomException $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => $ex->getCode(),
                "user_message" => "Usuario ou senha Inválidos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 001,
                "user_message" => "Erro Inseperado",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }
    //método que atualiza o token através de um refreshToken válido
    public function resfresh_token(Request $request, Response $response, array $args): Response
    {
        try {
            //passa o copo da requisição para uma variável 
            $data = $request->getParsedBody();

            //passa o token_refresh para uma variável string
            $resfreshToken = $data['refresh_token'];

            //decodifica a string passando para uma nova variável
            $resfreshTokenDecoded = JWT::decode(
                $resfreshToken,
                getenv('JWT_SECRET_KEY'),
                ['HS256']
            );

            //instancia um novo objeto para comunicar com a tabela de Tokens no banco de dados
            $tokensDAO = new TokensDAO();

            //chama o método que Verifica se o TOkenrefresh existe no banco de dados
            $resfreshTokenExists = $tokensDAO->verifyRefreshToken($resfreshToken);

            //se não existir retorna status 401 de erro
            if (!$resfreshTokenExists)
                return $response->withJson([
                    "error" => \Exception::class,
                    "status" => 400,
                    "code" => 9,
                    "user_message" => "RefreshToken inexistente ou expirado",
                    "developer_message" => "Tentativa de criação de token atraves de item inexistente na base de dados",
                ], 400);

            /*declara objeto que será usado para comunicar-se
        com a tabela usuarios no banco de dados*/
            $usuariosDAO = new UsuariosDAO;
            $usuario = $usuariosDAO->getUserByEmail($resfreshTokenDecoded->email);

            /*verifica se a variável que retornou a pesquisa no banco de dados atravé do email está vazia
            e retorna status 401 de erro */
            if (is_null($usuario))
                return $response->withJson([
                    "error" => \Exception::class,
                    "status" => 400,
                    "code" => 22,
                    "user_message" => "Não foi possivel criar o RefreshToken porque não foram obtidas nenhuma informação do usuário através de seu email " . $resfreshTokenDecoded->email,
                    "developer_message" => "Informações do Usuário não foram encontradas através da chave Unica. Verifique se o usuario com o email " . $resfreshTokenDecoded->email . " existe na basse de dados",
                ], 400);

            //declara uma nova data de expiração
            $expired_date = (new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->modify('+2 days')->format('Y-m-d H:i:s');

            $response = $this->CreateToken($response, $usuario, $expired_date);

            return $response;
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 21,
                "user_message" => "Erro Inseperado ao gerar novo RefreshToken",
                "developer_message" => $ex->getMessage(),
            ], 500);
        }
    }

    //método que cria um token no banco de dados
    public function CreateToken(Response $response, UsuarioModel $usuario, string $expired_date): Response
    {
        try {
            //define os dados do Token com email, nome, id e data de expiração
            $tokenPayload = [
                'sub' => $usuario->getId(),
                'name' => $usuario->getNome(),
                'email' => $usuario->getEmail(),
                'expired_at' => $expired_date
            ];

            /*codifica os Dados utilizando uma constante localizada em env.php
        que contém a chave secreta para validar o token*/
            $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

            //cria um array com o email e um valor randômico unico
            $resfreshTokenPayload = [
                'email' => $usuario->getEmail(),
                'random' => uniqid()
            ];

            //tranforma o array em um token usando a chave secreta 
            $resfresToken = JWT::encode($resfreshTokenPayload, getenv('JWT_SECRET_KEY'));

            //declara uma varivel com modelo de TOken e parra as informações criada para ela 
            $tokenModel = new TokenModel();
            //tempo de expiração
            $tokenModel->setExpired_at($expired_date)
                //refresh_token(será usado para pegar um novo token caso o token principal esteja expirado)
                ->setRefresh_token($resfresToken)
                //token principal
                ->setToken($token)
                //passando o Id do usuario
                ->setUsuarios_id($usuario->getId())
                ->setActive(1);

            //declara uma variável para executar funções no banco de dados
            $TokensDAO = new TokensDAO();

            //Inserindo o Token criado no banco de dados
            $TokensDAO->createToken($tokenModel);

            //retorna o Token e o Refresh_Token em JSon para o usuário
            $response = $response->withjson([
                "token" => $token,
                "refresh_token" => $resfresToken,
                "status" => 200,
                "error" => "Nenhum Erro Encontrado",
                "user_message" => "Login Efetuado com sucesso",
                "id_user" => $usuario->getId(),
                "tag_casa" => $usuario->getTag_casa(),
                "id_casa" => $usuario->getId_casa(),
                "nome_usuario" => $usuario->getNome(),
                "nivel_usuario" => $usuario->getNivelUsuario()

            ]);

            //retorna o Json 
            return $response;
            //code...
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 20,
                "user_message" => "Erro Inseperado ao Criar Token",
                "developer_message" => $ex->getMessage(),
            ], 500);
        }
    }

    //método que faz o cadastro comum do usuário
    public function cadastroUsuario(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $CasaModel = new CasaModel();
            $UsuarioModel = new UsuarioModel();
            $cadastra = new UsuariosDAO();

            $UsuarioModel->setNome(strtolower($data['nome_usuario']))
                ->setEmail(strtolower($data['email']))
                ->setSenha($data['senha']);

            $CasaModel->setCep($data['cep_usuario'])
                ->setCidade($data['cidade_usuario'])
                ->setBairro($data['bairro_usuario'])
                ->setEndereco($data['endereco_usuario'])
                ->setTelefone($data['telefone_usuario'])
                ->setTagCasa($this->criaTagHome());

            $cadastra->cadastraUsuario($UsuarioModel, $CasaModel);

            return $response->withJson([
                "error" => 'Sem Erros',
                "status" => 200,
                "code" => 0,
                "user_message" => "Cadastrado feito com sucesso",
                "developer_message" => "Inserção Efetuada com sucesso no banco de Dados",
            ], 200);

            return $response;
        } catch (\PDOException $ex) {
            return $response->withJson([
                "error" => \PDOException::class,
                "status" => 400,
                "code" => 004,
                "user_message" => "Email já existe",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 001,
                "user_message" => "Erro Inseperado",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }

    //faz o cadastro de um usuario numa casa através de uma TagHome
    public function cadastroUsuarioTagHome(Request $request, Response $response, array $args): Response
    {
        try {

            $data = $request->getParsedBody();
            $CasaModel = new CasaModel();
            $UsuarioModel = new UsuarioModel();
            $cadastraTagHome = new UsuariosDAO();
            $UsuarioModel->setNome(strtolower($data['nome_usuario']))
                ->setEmail(strtolower($data['email']))
                ->setSenha($data['senha']);
            $CasaModel->setTagCasa((string) $data['tag_casa']);

            if ($cadastraTagHome->tagExiste(strval($CasaModel->getTagCasa()))) {
                $cadastraTagHome->cadastraUsuarioTagHome($UsuarioModel, $CasaModel);
                return $response->withJson([
                    "error" => 'Sem Erros',
                    "status" => 200,
                    "code" => 0,
                    "user_message" => "Cadastrado via TagHome feito com sucesso",
                    "developer_message" => "Inserção Efetuada com sucesso no banco de Dados",
                ], 200);
            } else {
                throw new CustomException('TagHome não encontrada no banco de Dados', 400);
            }
        } catch (CustomException $ex) {
            return $response->withJson([
                "error" => \CustomException::class,
                "status" => 400,
                "code" => 11,
                "user_message" => "TagHome Inválida",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } catch (\PDOException $ex) {
            return $response->withJson([
                "error" => \PDOException::class,
                "status" => 400,
                "code" => 004,
                "user_message" => "Email já existe",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 001,
                "user_message" => "Erro Inseperado ao Cadastrar Usuario",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }

    //cria uma TagHome
    public function criaTagHome(): string
    {
        $usuariosDAO = new UsuariosDAO;
        do {

            $rnumlet = array();
            //gerando os valores para as letras e numeros
            for ($i = 0; $i < 4; $i++) {
                $rlet = chr(rand(65, 90));
                $rnumb = rand(1000, 9999);
                //passando do valor para uma tag
                $rnumlet[$i] = $rlet . $rnumb;
            }
            $tag = "@";
            //pegando os valores inciais dos Indices de cada Array 
            for ($k = 3; $k >= 0; $k--) {
                $tag .= substr($rnumlet[$k], 0, 2);
            }
            
        } while ($usuariosDAO->tagExiste($tag) == true);
        return $tag;
    }
}

