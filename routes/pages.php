<?php


use \App\Http\Response;
use \App\Controller\Pages;



// DEFININDO ROTAS


// ROTA HOME
$obRouter->get('/', [
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);


// ROTA ABOUT
$obRouter->get('/about', [
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);