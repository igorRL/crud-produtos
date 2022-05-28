<?php

require __DIR__.'/vendor/autoload.php';

use App\Common\Environment;
use App\Http\Router;
use App\Utils\View;

// RECEBENDO VARIAVEIS DE AMBIENTE
Environment::load(__DIR__);
$env = getenv();

// DEFININDO A CONSTANTE URL
define('URL', getenv('URL'));

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