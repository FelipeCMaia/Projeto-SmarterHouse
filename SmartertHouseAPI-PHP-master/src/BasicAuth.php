<?php 
//incluindo em src
namespace src;
//usa a classe de autenticação basica do tuupola
use Tuupola\Middleware\HttpBasicAuthentication;

//função que faz uma utenticação basica
function BasicAuth():HttpBasicAuthentication{
    //retorna um usuario e senha para autenticação
    return new HttpBasicAuthentication([
        "users"=>[
            "root" => "test123"
        ]
    ]);
}