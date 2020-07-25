<?php 
//incluindo em src

namespace src;
//declarando as configurações do SLIM
function SlimConfiguration(): \Slim\Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' =>getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];
    
    //retornando um container com as configurações
    return new \Slim\Container($configuration);

}