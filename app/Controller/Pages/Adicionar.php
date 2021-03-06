<?php

namespace App\Controller\Pages;

use App\Db\Database;
use App\Utils\View;
use App\Model\Entity\Organization;
use App\Model\Entity\Products;

class Adicionar extends Main
{

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */
    public static function getAdicionar()
    {

        
        // RECUPERANDO O OBJETO COM AS INFORMAÇÔES DA ORGANIZAÇÂO
        $obOrganization = new Organization;


        // DADOS RENDERIZADOS DO CONTEÚDO DA PÀGINA
        $content = View::render('pages/adicionar', [
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
        // DADOS DO POST VARS
        $postVars = $request->getPostVars();
        $files = $request->getFiles();

        $obProduct = new Products;
        $obProduct->productId = $postVars['product-id'];
        $obProduct->productStoke = $postVars['product-stoke'];
        $obProduct->productTitle = $postVars['product-title'];
        $obProduct->productDescription = $postVars['product-description'];
        $obProduct->productPrice = $postVars['product-price'];
        $obProduct->productImages = $files['product-images'];

        if($obProduct->register())
        {
            // upload dos arquivos
            $obProduct->upLoadFiles();
        }
        return self::getAdicionar();
    }
}
