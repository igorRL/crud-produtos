<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Main{

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */

    public static function getHome(){
        $content = View::render('pages/home',[
            'name' => 'Teste Admissional Excellent Sistemas',
            'description' => 'Teste prático da Excellent Sistemas: CRUDE Produtos em PWA'
        ]);

        return parent::getMain('Título',$content);
    }

}