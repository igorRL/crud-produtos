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
$obRouter->get('/login/adicionar', [
    function(){
        return new Response(200, Pages\Adicionar::getAdicionar());
    }
]);


// ROTA LOGIN
$obRouter->post('/login/adicionar', [
    function($request){
        return new Response(200, Pages\Adicionar::insertProduct($request));
        header('location: '.URL.'/login');
        die;
    }
]);


// ROTA EDITAR PRODUTO
$obRouter->get('/login/editar', [
    function(){
        if(!isset($_GET['id']) or !is_numeric($_GET['id']) )
        {
            header('location: '.URL.'/login');
            die;
        }
        return new Response(200, Pages\Editar::getEditar());
    }
]);


// ROTA EDITAR PRODUTO
$obRouter->post('/login/editar', [
    function($request){
        return new Response(200, Pages\Editar::updateProduct($request));
        header('location: '.URL.'/login');
        die;
    }
]);

