<?php 

//incluindo a Classe Token a Uma namespace
namespace App\Models\MySQL\SmarterHouse;

//Modelo de Token no Banco de Dados
final class CasaModel
{ /**
    * @var int
    */
    private $idCasa;
    /**
    * @var string
    */
    private $tagCasa;
      /**
    * @var string
    */
    private $cep;
      /**
    * @var string
    */
    private $cidade;
      /**
    * @var string
    */
    private $bairro;
      /**
    * @var string
    */
    private $endereco;
      /**
    * @var string
    */
    private $telefone;



    /**
     * @return  int
     */ 
    public function getIdCasa():int
    {
        return $this->idCasa;
    }

    /**
     * @param  int  $idCasa
     * @return  self
     */ 
    public function setIdCasa(int $idCasa):self
    {
        $this->idCasa = $idCasa;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getTagCasa():string
    {
        return $this->tagCasa;
    }

    /**
     * @param  string  $tagCasa
     * @return  self
     */ 
    public function setTagCasa(string $tagCasa):self
    {
        $this->tagCasa = $tagCasa;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getCep():string
    {
        return $this->cep;
    }

    /**
     * @param  string  $cep
     * @return  self
     */ 
    public function setCep(string $cep):self
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getCidade():string
    {
        return $this->cidade;
    }

    /**
     * @param  string  $cidade
     * @return  self
     */ 
    public function setCidade(string $cidade):self
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getBairro():string
    {
        return $this->bairro;
    }

    /**
     * @param  string  $bairro
     * @return  self
     */ 
    public function setBairro(string $bairro):self
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getTelefone():string
    {
        return $this->telefone;
    }

    /**
     * @param  string  $telefone
     * @return  self
     */ 
    public function setTelefone(string $telefone):self
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getEndereco():string
    {
        return $this->endereco;
    }

    /**
     * @param  string  $endereco
     * @return  self
     */ 
    public function setEndereco(string $endereco):self
    {
        $this->endereco = $endereco;

        return $this;
    }
}
