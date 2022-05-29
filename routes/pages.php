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


// ROTA PRODUTOS EXIBE PRODUTOS (ROTA DINAMICA)
$obRouter->get('/products/{idProduct}/{action}', [
    function($idProduct,$action){
        return new Response(200, 'Produto '.$idProduct.' - '.$action);
    }
]);


// ROTA ABOUT
$obRouter->get('/about', [
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);


// ROTA INFO
$obRouter->get('/info', [
    function(){
        return new Response(200, Pages\Info::getInfo());
    }
]);


// ROTA LOGIN
$obRouter->get('/login', [
    function(){
        return new Response(200, Pages\Login::getLogin());
    }
]);


// ROTA LOGIN
$obRouter->post('/login', [
    function($request){
        echo '<pre>';
        print_r($request);
        echo '</pre>';
        exit;
        return new Response(200, Pages\Login::getLogin());
    }
]);