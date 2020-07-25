<?php

namespace App\DAO\MySQL\SmarterHouse;

//declara o uso da classe que representa o tipo do Usuario

use App\Models\MySQL\SmarterHouse\CasaModel;
use App\Models\MySQL\SmarterHouse\UsuarioModel;
use PDO;

//Class que contém as funções para os usuarios, essa classe Herda de Conexão
class UsuariosDAO extends Conexao
{

    //Declara o construtor e o chama
    public function __construct()
    {
        parent::__construct();
    }
    
    /*Função que verifica se um usuário Existe no Banco de dados através do email,
    se existir, pega todas as informações daquele usuário*/
    public function getUserByEmail(string $email): ?UsuarioModel
    {

        //prepara a query de seleção dos usuario pelo emaail
        $statement = $this->pdo->prepare('SELECT 
       tbl_user.NOME_USER, 
       tbl_user.SENHA_USER, 
       tbl_user.LOGIN_USER, 
       tbl_user.NIVEL_USER,
       tbl_casa.ID_CASA,
       tbl_casa.TAG_CASA,
        tbl_user.ID_USER 
        FROM tbl_casa 
        INNER JOIN tbl_user_casa 
        ON tbl_user_casa.ID_CASA = tbl_casa.ID_CASA 
        INNER JOIN tbl_user 
        ON tbl_user.ID_USER = tbl_user_casa.ID_USER
         WHERE
          tbl_user.LOGIN_USER = :email');



        //passa o valor do parâmetro passado pelo método para a query
        $statement->bindParam(
            'email',
            $email
        );

        //executa a função
        $statement->execute();

        //passa o retorno da query para um array; 
        $usuarios = $statement->fetchAll(\PDO::FETCH_ASSOC);

        //var_dump($usuarios);
        /*verfica o tamanho do array e se for maior 
       que 0 retorna o usuario pego no banco de dados*/
        if (count($usuarios) === 1) {
            $usuario = new UsuarioModel();
            $usuario->setId($usuarios[0]['ID_USER']);
            $usuario->setNome($usuarios[0]['NOME_USER']);
            $usuario->setEmail($usuarios[0]['LOGIN_USER']);/*email*/
            $usuario->setSenha($usuarios[0]['SENHA_USER']);
            $usuario->setId_casa($usuarios[0]['ID_CASA']);
            $usuario->setTag_casa($usuarios[0]['TAG_CASA']);
            $usuario->setNivelUsuario($usuarios[0]['NIVEL_USER']);
            // echo "<pre>";
            //var_dump($usuario);
            return $usuario;
        }
        //se nenhum usuário for encotrado, retorna null
        else {
            return null;
        }
    }

    public function cadastraUsuario(UsuarioModel $usuario, CasaModel $casa): bool
    {
        //INSERT USER
        $insert_user = $this->pdo->prepare('INSERT 
        INTO 
        tbl_user 
        (
            tbl_user.NOME_USER,
            tbl_user.LOGIN_USER,
            tbl_user.SENHA_USER,
            tbl_user.NIVEL_USER
            ) 
        VALUES 
        (
            :nome_usuario,
            :email_usuario,
            :senha_usuario,
            :nivel_usuario
        )
        ')->execute([
            'nome_usuario' => $usuario->getNome(),
            'email_usuario' => $usuario->getEmail(),
            'senha_usuario' => md5($usuario->getSenha()),
            "nivel_usuario" => 1
        ]);

        $usuario->setId((int) $this->pdo->lastInsertId());
        //INSERT CASA
        $insert_casa = $this->pdo->prepare('INSERT INTO tbl_casa
        (
             tbl_casa.TAG_CASA,
             tbl_casa.CEP, 
             tbl_casa.CIDADE, 
             tbl_casa.BAIRRO,
             tbl_casa.ENDERECO, 
             tbl_casa.TELEFONE
        ) 
        VALUES
        (
            :tag,                  
            :cep_usuario,
            :cidade_usuario,
            :bairro_usuario,
            :endereco_usuario,
            :telefone_usuario
        )
        ')->execute(
            [
                'tag' => $casa->getTagCasa(),
                'cep_usuario' => $casa->getCep(),
                'cidade_usuario' => $casa->getCidade(),
                'bairro_usuario' => $casa->getBairro(),
                'endereco_usuario' => $casa->getEndereco(),
                'telefone_usuario' => $casa->getTelefone(),
            ]
        );


        $casa->setIdCasa((int) $this->pdo->lastInsertId());

        //INSERT USER_CASA
        $insert_user_casa = $this->pdo->prepare('INSERT INTO tbl_user_casa
        (
             tbl_user_casa.ID_CASA,
              tbl_user_casa.ID_USER
        ) 
        VALUES 
        (
            :id_casa,
            :id_user
        );
        ')->execute(
            [
                'id_casa' => $casa->getIdCasa(),
                'id_user' =>  $usuario->getId()
            ]
        );

        $insert_mode_casa = $this->pdo->prepare("INSERT INTO mod_casas
         (
              mod_casas.ID_MOD,
              mod_casas.ID_CASA
         ) VALUES 
         ('1',:id_casa),
         ('2',:id_casa),
         ('3',:id_casa),
         ('4',:id_casa),
         ('5',:id_casa)
        ")->execute(
            [
                'id_casa' => $casa->getIdCasa(),
            ]
        );
        //SELECT NUM_MOD
        $select_mode_casa = $this->pdo->prepare('SELECT
         mod_casas.NUM_MOD 
         FROM mod_casas 
         WHERE mod_casas.ID_CASA = :id_casa
       ');

        $select_mode_casa->execute(['id_casa' => $casa->getIdCasa()]);
        $num_mod = $select_mode_casa->fetchAll(\PDO::FETCH_ASSOC);

        $insert_horarios = $this->pdo->prepare("INSERT INTO tbl_horarios 
        (
             tbl_horarios.NUM_MOD,
             tbl_horarios.DIA_ATIVIDADE,
             tbl_horarios.TEMPO_ATIVIDADE,
             tbl_horarios.VEZES_LIGADA_ATIVIDADE
        ) VALUES 
        (:num_mod,NOW(), '0','0'),
        (:num_mod1,NOW(),'0','0'),
        (:num_mod2,NOW(),'0','0'),
        (:num_mod3,NOW(),'0','0'),
        (:num_mod4,NOW(),'0','0')
        ")->execute(
            [
                'num_mod' => $num_mod[0]['NUM_MOD'],
                'num_mod1' => $num_mod[1]['NUM_MOD'],
                'num_mod2' => $num_mod[2]['NUM_MOD'],
                'num_mod3' => $num_mod[3]['NUM_MOD'],
                'num_mod4' => $num_mod[4]['NUM_MOD'],
            ]
        );

        return true;
    }

    public function cadastraUsuarioTagHome(UsuarioModel $usuario, CasaModel $casa): bool
    {

        //INSERT USUARIO
        $insert_casa = $this->pdo->prepare('INSERT INTO tbl_user
         (
             tbl_user.NOME_USER,
             tbl_user.LOGIN_USER,
             tbl_user.SENHA_USER,
             tbl_user.NIVEL_USER
         ) 
         VALUES 
         (
            :nome_usuario,
            :login_usuario,
            :senha_usuario,
            :nivel_usuario
         )
        ')->execute(
            [
                "nome_usuario" => $usuario->getNome(),
                "login_usuario" => $usuario->getEmail(),
                "senha_usuario" => md5($usuario->getSenha()),
                "nivel_usuario" => 0
            ]
        );
        $usuario->setId((int) $this->pdo->lastInsertId());

        //INSERT CASA
        $insert_casa = $this->pdo->prepare('SELECT 
             tbl_casa.ID_CASA 
             from tbl_casa 
             WHERE tbl_casa.TAG_CASA = :tag_casa
             ');

        $insert_casa->bindValue('tag_casa', $casa->getTagCasa());
        $insert_casa->execute();

        $id_casa = $insert_casa->fetchAll(\PDO::FETCH_ASSOC);

        $insert_user_casa = $this->pdo->prepare(
            'INSERT
         INTO tbl_user_casa
          (
              tbl_user_casa.ID_CASA,
              tbl_user_casa.ID_USER
          ) 
        VALUES (:id_casa,:id_user)'
        )
            ->execute(
                [
                    "id_casa" => $id_casa[0]['ID_CASA'],
                    "id_user" => $usuario->getId()
                ]
            );

        return false;
    }

    public function UsuarioExiste(int $id_usuario): bool
    {
        $statement = $this->pdo->prepare('SELECT * FROM tbl_user WHERE ID_USER = :id_usuario');
        $statement->bindParam("id_usuario", $id_usuario);
        $statement->execute();
        $quant = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($quant) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function SelecionaUsuario(int $id_usuario)
    {
        $a = $this->pdo->prepare("CALL pega_id_casa(:id_user, @id_casa);")
            ->execute(
                [
                    'id_user' => $id_usuario
                ]
            );

        $b = $this->pdo->prepare("SELECT @id_casa as id_casa");
        $b->execute();
        $id_casa = $b->fetchAll(\PDO::FETCH_ASSOC);

        $statement = $this->pdo->prepare('SELECT 
        tbl_user.NOME_USER as nome_user, 
        tbl_user.ID_USER as id_user, 
        tbl_user.LOGIN_USER as login_user,
        tbl_user.SENHA_USER as senha_user
        from tbl_user 
        INNER JOIN tbl_user_casa 
        On tbl_user_casa.ID_USER = tbl_user.ID_USER 
        Where tbl_user_casa.ID_CASA =:id_casa
        
        ');

        $statement->bindParam(":id_casa", $id_casa[0]['id_casa']);

        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function DeletaUsuario(int $id_usuario)
    {

        $statement = $this->pdo->prepare('DELETE FROM tbl_tokens WHERE ID_USER =:id_usuario;
        DELETE FROM tbl_user_casa WHERE ID_USER =:id_usuario;
        DELETE FROM tbl_user WHERE ID_USER =:id_usuario;
        ');

        $statement->bindParam("id_usuario", $id_usuario);

        $statement->execute();
    }

    public function AtualizaUsuario(UsuarioModel $usuario)
    {
        $senha = $usuario->getSenha();
        $id = $usuario->getId();
        $verificasenhamd5 = $this->pdo->prepare('SELECT SENHA_USER
         from tbl_user 
         WHERE SENHA_USER = MD5(:senha_user) and ID_USER = :id_user
        ');
        $verificasenhamd5->bindParam(":senha_user", $senha);
        $verificasenhamd5->bindParam(":id_user", $id);
        $verificasenhamd5->execute();

        $senhamd5 = $verificasenhamd5->fetchAll(PDO::FETCH_ASSOC);

        $verificasenha = $this->pdo->prepare('SELECT SENHA_USER
        from tbl_user 
        WHERE SENHA_USER = :senha_user and ID_USER = :id_user
       ');
        $verificasenha->bindParam(":senha_user", $senha);
        $verificasenha->bindParam(":id_user", $id);
        $verificasenha->execute();

        $senha = $verificasenha->fetchAll(PDO::FETCH_ASSOC);

        if (count($senhamd5) != 0) {
            $usuario->setSenha(md5($usuario->getSenha()));
        } else if (count($senha) != 0) {
            $usuario->setSenha($senha[0]["SENHA_USER"]);
        } else {
            $usuario->setSenha(md5($usuario->getSenha()));
        }


        $statement = $this->pdo->prepare('UPDATE tbl_user 
        SET 
        NOME_USER= :nome_user,
         SENHA_USER= :senha_user,
         LOGIN_USER = :login_user
          WHERE ID_USER = :id_user')->execute(
            [
                "nome_user" => $usuario->getNome(),
                "login_user" => $usuario->getEmail(),
                "senha_user" => $usuario->getSenha(),
                "id_user" => $usuario->getId(),
            ]
        );
    }

    public function tagExiste(string $tag): bool
    {
        $verificaTag = $this->pdo->prepare('SELECT 
        tbl_casa.TAG_CASA 
        from tbl_casa 
        where tbl_casa.TAG_CASA = :tag ');
        $verificaTag->bindParam('tag', $tag);
        $verificaTag->execute();
        $quant = $verificaTag->fetchAll(\PDO::FETCH_ASSOC);
        return count($quant) == 1 ? true : false;
    }
}
