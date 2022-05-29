<?php

require __DIR__.'/includes/app.php';

use App\Http\Router;

// INICIA O ROTEADOR
$obRouter = new Router(URL);

// INCLUI AS ROTAS DA PÁGINA
include __DIR__.'/routes/pages.php';

// IMPRIME O RESPONSE DA ROTA
$obRouter->run()
         ->sendResponse();