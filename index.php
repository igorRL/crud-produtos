<?php

require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages\Home;




define('URL', 'http://localhost/projetos/testes/excellent_sistemas/crud_produtos');



$obRouter = new Router(URL);

// DEFININDO ROTAS


// ROTA HOME
$obRouter->get('/', [
    function(){
        return new Response(200, Home::getHome());
    }
]);

// imprime o response da rota
$obRouter->run()
         ->sendResponse();