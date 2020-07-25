<?php 

//incluindo a Classe Token a Uma namespace
namespace App\Models\MySQL\SmarterHouse;

//Modelo de Token no Banco de Dados
final class ModCasaModel
{ 
    /**
    * @var int
    */
    private $numMod;

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
}