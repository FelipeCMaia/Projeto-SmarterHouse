<?php 

//incluindo a Classe Token a Uma namespace
namespace App\Models\MySQL\SmarterHouse;

//Modelo de Token no Banco de Dados
final class UsuarioModel
{ /**
    * @var int
    */
    private $id;
    /**
    * @var int
    */
    private $id_casa;
    /**
     * @var string
     */
    private $nome;
     /**
     * @var string
     */
    private $email;
     /**
     * @var string
     */
    private $senha;
     /**
     * @var string
     */
    private $tag_casa;
     /**
     * @var int
     */
    private $nivelUsuario;
    


 /**
     * @return int
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     * @param int  $id
     * @return self
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Get the value of nome
     *
     * @return  string
     */ 
    public function getNome():string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     * @param  string  $nome
     * @return  self
     */ 
    public function setNome(string $nome) : self
    {
        $this->nome = $nome;

        return $this;
    }
    

    /**
     * Get the value of email
     * @return  string
     */ 
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     * @param  string  $email
     * @return  self
     */ 
    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of senha
     * @return  string
     */ 
    public function getSenha():string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     * @param  string  $senha
     * @return  self
     */ 
    public function setSenha(string $senha):self
    {
        $this->senha = $senha;

        return $this;
    }

   

    /**
     * Get the value of id_casa
     *
     * @return  int
     */ 
    public function getId_casa():int
    {
        return $this->id_casa;
    }

    /**
     * Set the value of id_casa
     *
     * @param  int  $id_casa
     *
     * @return  self
     */ 
    public function setId_casa(int $id_casa):self
    {
        $this->id_casa = $id_casa;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getTag_casa():string
    {
        return $this->tag_casa;
    }

    /**
     * @param  string  $tag_casa
     * @return  self
     */ 
    public function setTag_casa(string $tag_casa):self
    {
        $this->tag_casa = $tag_casa;

        return $this;
    }

    /**
     * Get the value of nivelUsuario
     *
     * @return  int
     */ 
    public function getNivelUsuario()
    {
        return $this->nivelUsuario;
    }

    /**
     * Set the value of nivelUsuario
     *
     * @param  int  $nivelUsuario
     *
     * @return  self
     */ 
    public function setNivelUsuario(int $nivelUsuario):self
    {
        $this->nivelUsuario = $nivelUsuario;

        return $this;
    }
}