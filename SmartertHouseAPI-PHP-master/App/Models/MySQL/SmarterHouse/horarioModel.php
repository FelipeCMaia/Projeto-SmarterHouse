<?php 
//incluindo a Classe loja a namespace gerenciador_loja
namespace App\Models\MySQL\SmarterHouse;

//Modelo da Classe Loja
final class HorarioModel
{

    /**
     * @var  int 
     */
    private $idHorario;
      /**
     * @var  int 
     */
    private $numMod;
      /**
     * @var  int 
     */
    private $tempoAtividade;
      /**
     * @var  int 
     */
    private $vezesLigadas;
      /**
     * @var  string 
     */
    private $diaAtividade;
     

    /**
     * @return  int
     */ 
    public function getIdHorario():int
    {
        return $this->idHorario;
    }

    /**
     * @param  int  $idHorario
     * @return  self
     */ 
    public function setIdHorario(int $idHorario):self
    {
        $this->idHorario = $idHorario;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getNumMod():int
    {
        return $this->numMod;
    }

    /**
     * @param  int  $numMod
     * @return  self
     */ 
    public function setNumMod(int $numMod):self
    {
        $this->numMod = $numMod;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getTempoAtividade():int
    {
        return $this->tempoAtividade;
    }

    /**
     * @param  int  $tempoAtividade
     * @return  self
     */ 
    public function setTempoAtividade(int $tempoAtividade):self
    {
        $this->tempoAtividade = $tempoAtividade;

        return $this;
    }

    /**
     * @return  int
     */ 
    public function getVezesLigadas():int
    {
        return $this->vezesLigadas;
    }

    /**
     * @param  int  $vezesLigadas
     * @return  self
     */ 
    public function setVezesLigadas(int $vezesLigadas):self
    {
        $this->vezesLigadas = $vezesLigadas;

        return $this;
    }

    /**
     * @return  string
     */ 
    public function getDiaAtividade():string
    {
        return $this->diaAtividade;
    }

    /**
     * @param  string  $diaAtividade
     * @return  self
     */ 
    public function setDiaAtividade(string $diaAtividade):self
    {
        $this->diaAtividade = $diaAtividade;

        return $this;
    }
}