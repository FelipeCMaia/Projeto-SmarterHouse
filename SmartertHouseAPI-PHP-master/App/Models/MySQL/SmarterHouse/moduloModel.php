<?php 

//incluindo a Classe Token a Uma namespace
namespace App\Models\MySQL\SmarterHouse;

//Modelo de Token no Banco de Dados
final class ModuloModel
{ /**
    * @var int
    */
    private $idMod;

    /**
     * @return  int
     */ 
    public function getIdMod():int
    {
        return $this->id_mod;
    }

    /**
     * @param  int  $id_mod
     * @return  self
     */ 
    public function setIdMod(int $id_mod):self
    {
        $this->id_mod = $id_mod;

        return $this;
    }

}