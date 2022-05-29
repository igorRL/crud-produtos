<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;
use App\Model\Entity\Products;

class Login extends Main
{

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */
    public static function getLogin()
    {

        
        // RECUPERANDO O OBJETO COM AS INFORMAÇÔES DA ORGANIZAÇÂO
        $obOrganization = new Organization;


        // DADOS RENDERIZADOS DO CONTEÚDO DA PÀGINA
        $content = View::render('pages/login', [
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
        return parent::getMain('Área do usuário', $content, $footer);
    }



    /**
     * Método resonsável por cadastrar um novo produto
     *
     * @param request $request
     * @return string
     */
    public static function insertProduct($request)
    {
        echo '<pre>';
        print_r($request);
        echo '</pre>';
        exit;
        // DADOS DO POST VARS
        $postVars = $request->getPostVars();
        $files = $request->getFiles();

        $obProduct = new Products;
        $obProduct->productId = $postVars['product-id'];
        $obProduct->productStoke = $postVars['product-stoke'];
        $obProduct->productTitle = $postVars['product-title'];
        $obProduct->productDescription = $postVars['product-description'];
        $obProduct->productImages = $files['product-images'];

        if($obProduct->register())
        {
            // upload dos arquivos
            $obProduct->upLoadFiles();
        }

        return self::getLogin();
    }
}
