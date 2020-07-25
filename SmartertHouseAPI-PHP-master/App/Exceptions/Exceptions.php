<?php
//adiconando o arquivo testException a namespae Exception
namespace App\Exceptions;

//criando uma classe Exceção que herda de Exception
class CustomException extends \Exception
{
    //criando o Contrutor que executa o contrutor da classe pai Exception
    public function __construct($message, $code = 0, Exception $previus = null)
    {
        parent::__construct($message, $code, $previus);
    }
    
    //função que retorna uma strin com o codigo e mensagem do erro
    public function __toString(): string{
        return __CLASS__ .":[{$this->code}]: {$this->message}\n";
    }
}

