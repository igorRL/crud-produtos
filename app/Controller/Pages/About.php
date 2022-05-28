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

        // ORGANIZAÇÃO
        $obOrganization = new Organization;

        // EDITANDO CONTEÚDO DA PÁGINA
        $content = View::render('pages/about',[
            'name' => 'Teste Admissional Excellent Sistemas',
        ]);


        // ENVIANDO DADOS PARA MAIN
        return parent::getMain('sobre',$content);
    }

}