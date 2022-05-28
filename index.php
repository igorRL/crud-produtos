<?php

require __DIR__.'/vendor/autoload.php';

use App\Http\Router;
use App\Utils\View;

define('URL', 'http://localhost:8080');

// DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'Url'=> URL
]);

// INICIA O ROTEADOR
$obRouter = new Router(URL);

// INCLUI AS ROTAS DA PÁGINA
include __DIR__.'/routes/pages.php';

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()
         ->sendResponse();