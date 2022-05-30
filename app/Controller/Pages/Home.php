<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Main
{

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */
    public static function getHome()
    {

        
        // RECUPERANDO O OBJETO COM AS INFORMAÇÔES DA ORGANIZAÇÂO
        $obOrganization = new Organization;


        // DADOS RENDERIZADOS DO CONTEÚDO DA PÀGINA
        $content = View::render('pages/home', [
            'organization-name' => $obOrganization->name,
            'organization-description' => $obOrganization->description,
            'organization-site' => $obOrganization->site
        ]);


        // DADOS RENDERIZADOS DO FOOTHER DA PÁGINA
        $footer = View::render('pages/layouts/components/footer', [
            'organization-name' => $obOrganization->name,
            'organization-description' => $obOrganization->description,
            'organization-site' => $obOrganization->site,
            'date-year' =>date('Y'),
        ]);

        // ENVIAR CONTEÚDOS RENDERIZADOS PARA MAIN
        return parent::getMain('Bem vindo!', $content, $footer);
    }
}
