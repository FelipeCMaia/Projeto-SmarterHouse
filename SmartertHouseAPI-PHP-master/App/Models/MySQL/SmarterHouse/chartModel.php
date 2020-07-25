<?php 
//incluindo a Classe loja a namespace gerenciador_loja
namespace App\Models\MySQL\SmarterHouse;

//Modelo da Classe Loja
final class ChartModel
{
    /**
     * @var \Datetime 
     */
    private $dia;
       /**
     * @var int 
     */
    private $tempo;
        /**
     * @var int 
     */
    private $vezes_ligadas;
       /**
     * @var int 
     */
    private $id_mod_numb;
           /**
     * @var string 
     */
    private $nome_mod;

    /**
     * @return  \Datetime
     */ 
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param  \Datetime  $dia
     * @return  self
     */ 
    public function setDia(\Datetime $dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getTempo():int
    {
        return $this->tempo;
    }

    /**
     * @param  int  $tempo
     * @return  self
     */ 
    public function setTempo(int $tempo):self
    {
        $this->tempo = $tempo;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getVezes_ligadas():int
    {
        return $this->vezes_ligadas;
    }

    /**
     * @param  int  $vezes_ligadas
     * @return  self
     */ 
    public function setVezes_ligadas(int $vezes_ligadas):self
    {
        $this->vezes_ligadas = $vezes_ligadas;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getId_mod_numb():int
    {
        return $this->id_mod_numb;
    }

    /**
     * @param  int  $id_mod_numb
     * @return  self
     */ 
    public function setId_mod_numb(int $id_mod_numb):self
    {
        $this->id_mod_numb = $id_mod_numb;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getNome_mod():string
    {
        return $this->nome_mod;
    }

    /**
     * @param  string  $nome_mod
     * @return  self
     */ 
    public function setNome_mod(string $nome_mod):self
    {
        $this->nome_mod = $nome_mod;
        return $this;
    }
}