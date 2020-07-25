<?php

namespace App\DAO\MySQL\SmarterHouse;

//Usa o modelo do Tipo Token localizado na Pasta Models

use App\Models\MySQL\SmarterHouse\CasaModel;
use App\Models\MySQL\SmarterHouse\ChartModel;
use App\Models\MySQL\SmarterHouse\HorarioModel;
use App\Models\MySQL\SmarterHouse\ModCasaModel;
use App\Models\MySQL\SmarterHouse\ModuloModel;
use App\Models\MySQL\SmarterHouse\TokenModel;

class ChartsDAO extends Conexao
{

    //cria o contrutor e chama-o
    public function __construct()
    {
        parent::__construct();
    }

    public function DataDAO(int $id_usuario, int $tipo_mod)
    {


        $a = $this->pdo->prepare("CALL pega_id_casa(:id_user, @id_casa);");
        $a->bindParam('id_user', $id_usuario);
        $a->execute();
        $b = $this->pdo->prepare("SELECT @id_casa as id_casa");
        $b->execute();
        $id_casa = $b->fetchAll(\PDO::FETCH_ASSOC);


        $query = $this->pdo->prepare("SELECT 
        tbl_horarios.DIA_ATIVIDADE as 'dia',
        tbl_horarios.TEMPO_ATIVIDADE as 'tempo',
        tbl_horarios.VEZES_LIGADA_ATIVIDADE as 'vezes_ligadas',
        tbl_horarios.NUM_MOD as 'id_mod_numb',
        tbl_modulos.NOME_MOD as 'nome_mod', 
        mod_casas.ID_MOD as 'id_mod'
        FROM tbl_horarios 
        INNER JOIN mod_casas ON tbl_horarios.NUM_MOD = mod_casas.NUM_MOD 
        INNER JOIN tbl_modulos ON tbl_modulos.ID_MOD = mod_casas.ID_MOD
        WHERE mod_casas.ID_MOD = :tipo_mod 
        and mod_casas.ID_CASA = :id_casa  
        ORDER BY DIA_ATIVIDADE ASC
        ");
        $query->bindParam('tipo_mod', $tipo_mod);
        $query->bindParam('id_casa', $id_casa[0]['id_casa']);
        $query->execute();

        $resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }
    public function ContaDadosDAO(int $id_usuario, int $tipo_mod)
    {


        $a = $this->pdo->prepare("CALL pega_id_casa(:id_user, @id_casa);");
        $a->bindParam('id_user', $id_usuario);
        $a->execute();
        $b = $this->pdo->prepare("SELECT @id_casa as id_casa");
        $b->execute();
        $id_casa = $b->fetchAll(\PDO::FETCH_ASSOC);

        $query = $this->pdo->prepare("SELECT 
        count(tbl_horarios.NUM_MOD) as 'quant_elem_grafic' 
        from tbl_horarios 
        INNER JOIN mod_casas ON tbl_horarios.NUM_MOD = mod_casas.NUM_MOD WHERE mod_casas.ID_MOD = :tipo_mod
        and mod_casas.ID_CASA = :id_casa group by tbl_horarios.NUM_MOD 
        having count(tbl_horarios.NUM_MOD)>0
        ");
        $query->bindParam('tipo_mod', $tipo_mod);
        $query->bindParam('id_casa', $id_casa[0]['id_casa']);
        $query->execute();

        $resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado[0];
    }

    public function SelecionLabelsDateDAO(int $id_usuario, int $tipo_mod)
    {


        $a = $this->pdo->prepare("CALL pega_id_casa(:id_user, @id_casa);");
        $a->bindParam('id_user', $id_usuario);
        $a->execute();
        $b = $this->pdo->prepare("SELECT @id_casa as id_casa");
        $b->execute();
        $id_casa = $b->fetchAll(\PDO::FETCH_ASSOC);

        $query = $this->pdo->prepare("SELECT DISTINCT 
        tbl_horarios.DIA_ATIVIDADE as 'dia_atividade' 
        from tbl_horarios 
        INNER JOIN mod_casas 
        ON mod_casas.NUM_MOD = tbl_horarios.NUM_MOD 
        WHERE mod_casas.ID_MOD = :tipo_mod
        and mod_casas.ID_CASA = :id_casa
        ORDER BY tbl_horarios.DIA_ATIVIDADE ASC
        ");
        $query->bindParam('tipo_mod', $tipo_mod);
        $query->bindParam('id_casa', $id_casa[0]['id_casa']);
        $query->execute();

        $resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function SelecionaModulosDAO(int $id_usuario, int $tipo_mod)
    {


        $a = $this->pdo->prepare("CALL pega_id_casa(:id_user, @id_casa);");
        $a->bindParam('id_user', $id_usuario);
        $a->execute();
        $b = $this->pdo->prepare("SELECT @id_casa as id_casa");
        $b->execute();
        $id_casa = $b->fetchAll(\PDO::FETCH_ASSOC);

        $query = $this->pdo->prepare("SELECT 
        DISTINCT tbl_horarios.NUM_MOD as 'id_mod' 
        from tbl_horarios 
        INNER JOIN mod_casas
         ON tbl_horarios.NUM_MOD = mod_casas.NUM_MOD
        WHERE mod_casas.ID_MOD = :tipo_mod 
        and mod_casas.ID_CASA = :id_casa");
        $query->bindParam('tipo_mod', $tipo_mod);
        $query->bindParam('id_casa', $id_casa[0]['id_casa']);
        $query->execute();

        $resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function AtualizaDadosGraficoDAO(HorarioModel $horarioModel, ModCasaModel $modCasaModel): bool
    {

        $statement = $this->pdo->prepare('UPDATE tbl_horarios 
            SET 
                TEMPO_ATIVIDADE=:tempo_atividade, 
                VEZES_LIGADA_ATIVIDADE=:vezes_ligadas 
            WHERE 
                NUM_MOD = :num_mod 
            and
                DIA_ATIVIDADE = DATE_FORMAT(NOW(),"%Y-%m-%d")
             
             ');
             $statement->execute([
                "num_mod" => $modCasaModel->getNumMod(),
                "tempo_atividade" => $horarioModel->getTempoAtividade(),
                "vezes_ligadas" => $horarioModel->getVezesLigadas(),

            ]);
            
           return $statement->rowCount() == 0 ? false : true;
    }
}
