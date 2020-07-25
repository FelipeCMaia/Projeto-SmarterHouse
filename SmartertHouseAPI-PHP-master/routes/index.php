<?php
//Declarando as funções cotidas em src
use function src\{
        BasicAuth,
        jwtAuth,
        SlimConfiguration
};

//Declarando as Classes cotidas em Controllers
use App\Controllers\{
        AuthController,
    ChartController,
    ExceptionController,
        LojaController,
        ProdutoController,
    TarefaController,
    UsuarioController
};

//declarando o local da classe de verificão da data de expiração
use App\Middlewares\JwtDateMiddleware;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//criando uma nova instância de SLim
$app = new \Slim\App(SlimConfiguration());

//cors 
$app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    });
    

$app->group('/v1', function () use ($app) {
        //Rota de login 
        $app->post('/login', AuthController::class . ':login');
        $app->post('/cadastro',  AuthController::class . ':cadastroUsuario');
        $app->post('/cadastro-taghome',  AuthController::class . ':cadastroUsuarioTagHome');   
        $app->group('/grafico', function() use($app) {
                $app->get('/{id_user}/{tipo_mod}', ChartController::class.':Data');
                $app->get('/conta-dados/{id_user}/{tipo_mod}', ChartController::class.':ContaDados');
                $app->get('/seleciona-labels-date/{id_user}/{tipo_mod}', ChartController::class.':SelecionaLabelsDate');
                $app->get('/seleciona-modulos/{id_user}/{tipo_mod}', ChartController::class.':SelecionaModulos');
                $app->post('/insere-dados-horario', ChartController::class.':AtualizaDadosGrafico');
        })
        ->add((new JwtDateMiddleware()))
        ->add(jwtAuth());

        $app->group('/manutencao-usuario', function() use($app){
                $app->delete('/deleta/{id_usuario}',UsuarioController::class. ':DeletaUsuario');
                $app->put('/atualiza',UsuarioController::class .':AtualizaUsuario');
                $app->get('/seleciona/{id_usuario}',UsuarioController::class. ':SelecionaUsuario');
        });
        
        $app->post('/refresh-token', AuthController::class . ':resfresh_token');
       
});

//Executando o Método $app
$app->run();
