<?php

require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;

define('URL', 'http://localhost/crud_produtos');



$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

// imprime o response da rota
$obRouter->run()
         ->sendResponse();