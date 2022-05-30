<?php

require __DIR__.'/../vendor/autoload.php';

use App\Common\Environment;
use App\Db\Database;
use App\Utils\View;
use App\Model\Entity;
use App\Http\Middleware\Queue as MiddlewareQueue;

// RECEBENDO VARIAVEIS DE AMBIENTE
Environment::load(__DIR__.'/../');

// DEFINE AS CONFIGRAÇÕES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

// DEFININDO A CONSTANTE URL
define('URL', getenv('URL'));

// DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'Url'=> URL
]);


// DEFINE O MAPEAMENTO
MiddlewareQueue::setMap([
    'maintenance'=> \App\Http\Middleware\Maintenance::class,
    'required-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class
    
]);


// DEFINE OS MIDDLEARES PADÕES (EXECUTADOS EM TODAS AS ROTAS)
MiddlewareQueue::setDefault([
    'maintenance'
]);