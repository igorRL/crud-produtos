<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Home{

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */

    public static function getHome(){
        return View::render('pages/home',[
            'name' => 'Teste Excellent Sistemas',
            'description' => 'Teste prático da Excellent Sistemas: CRUDE Produtos em PWA'
        ]);
    }

}