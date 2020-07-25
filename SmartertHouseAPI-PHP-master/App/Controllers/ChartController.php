<?php
//declarando Loja Controller a namespace controller
namespace App\Controllers;

//incluindo diretórios de classes que serão usadas

use App\DAO\MySQL\SmarterHouse\ChartsDAO;
use App\Exceptions\CustomException;
use App\Models\MySQL\SmarterHouse\HorarioModel;
use App\Models\MySQL\SmarterHouse\ModCasaModel;
use InvalidArgumentException;
use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};

//classe com os métodos de Loja
final class ChartController
{
    //Métodos relacionados ao envio de informações para o gráfico no Site

    public function Data(Request $request, Response $response, array $args): Response
    {
        try {
            //code...
            $chartDAO = new ChartsDAO();


            $chart = $chartDAO->DataDAO($args['id_user'], $args['tipo_mod']);
            $arr = array();

            foreach ($chart as $r) {
                $arr[] = array(
                    "id_mod" => ([
                        array(
                            "dia" => $r['dia'],
                            "tempo" => $r['tempo'],
                            "vezes_ligadas" => $r['vezes_ligadas'],
                        ),
                        "id_mod_numb" => $r['id_mod_numb'],
                        "nome_mod" => $r['nome_mod']
                    ])
                );
            }
            $response = $response->withJson($arr);
            return $response;
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 500,
                "code" => 23,
                "user_message" => "Erro ao buscar informações dos gráficos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }

    public function ContaDados(Request $request, Response $response, array $args): Response
    {
        try {

            $chartDAO = new ChartsDAO();

            $chart = $chartDAO->ContaDadosDAO($args['id_user'], $args['tipo_mod']);
            $response = $response->withJson($chart);
            return $response;
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 24,
                "user_message" => "Erro na contagem de módulos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }

    public function SelecionaLabelsDate(Request $request, Response $response, array $args): Response
    {
        try {

            $chartDAO = new ChartsDAO();
            $chart = $chartDAO->SelecionLabelsDateDAO($args['id_user'], $args['tipo_mod']);
            $response = $response->withJson($chart);
            return $response;
        
        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 25,
                "user_message" => "Erro na seleção da Datas dos módulos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }

    public function SelecionaModulos(Request $request, Response $response, array $args): Response
    {
        try {

            $chartDAO = new ChartsDAO();
            $chart = $chartDAO->SelecionaModulosDAO($args['id_user'], $args['tipo_mod']);
            $response = $response->withJson($chart);
            return $response;

        } catch (\Exception | \Throwable $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 26,
                "user_message" => "Erro na seleção do id dos módulos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }

        
    }

    public function AtualizaDadosGrafico(Request $request, Response $response, array $args): Response
    {
        
        try {

            $data = $request->getParsedBody();
            if (!isset($data['tempo_atividade'],
            $data['vezes_ligadas'],
            $data['num_mod'])) {
                throw new CustomException('Um ou mais parãmetros faltando no corpo da requisição');
                return $response->withStatus(400);
            }
            $horarioModel = new HorarioModel();
            $ChartsDAO = new ChartsDAO();
            $ModCasaMOdel = new ModCasaModel();

            $horarioModel->setTempoAtividade($data['tempo_atividade'])
                ->setVezesLigadas($data['vezes_ligadas']);

            $ModCasaMOdel->setNumMod($data['num_mod']);

            if($ChartsDAO->AtualizaDadosGraficoDAO($horarioModel, $ModCasaMOdel)){
                
                return $response->withJson([
                    "error" => "Nenhum Erro Encontrado",
                    "status" => 200,
                    "code" => 000,
                    "user_message" => "Dados Atualizados Com Sucesso",
                    "developer_message" => "Nenhum Erro Encontrado",
                ], 200);
            }else{
                return $response->withJson([
                    "error" => "Dados de módulo não atualizado",
                    "status" => 400,
                    "code" => 027,
                    "user_message" => "Dados não atualizados",
                    "developer_message" => "Não foi possível Atualizar os dados porque um ou mais parâmetros passados no corpo da requisição estão incorretos, verifique se o Número do Módulo está correto e tente novamente",
                ], 200);
               
            }


        } catch (\CustomException | \Throwable $ex) {
            return $response->withJson([
                "error" => \CustomException::class,
                "status" => 400,
                "code" => 007,
                "user_message" => "Erro ao Atualizar Dados do Gráfico",
                "developer_message" => $ex->getMessage(),
            ], 400);
        } catch (\Exception  $ex) {
            return $response->withJson([
                "error" => \Exception::class,
                "status" => 400,
                "code" => 006,
                "user_message" => "Erro Inseperado ao Atualizar Dados do Módulos",
                "developer_message" => $ex->getMessage(),
            ], 400);
        }
    }
}
