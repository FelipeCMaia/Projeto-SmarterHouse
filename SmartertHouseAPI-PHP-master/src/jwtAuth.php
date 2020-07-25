<?php 
//incluindo em src

namespace src;
//usando a classe do tuupola para a autenticação do JWT
use Tuupola\Middleware\JwtAuthentication;

//funçção para a autenticação
function jwtAuth(): JwtAuthentication
{
    //valida e retorna um objeto jwtAuhtentication com a chave secreta 
    return new JwtAuthentication([
        'secret' => getenv('JWT_SECRET_KEY'),
        'attribute' => 'jwt'
    ]);
   
}
