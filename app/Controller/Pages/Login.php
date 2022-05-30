<?php

namespace App\Controller\Pages;

use App\Db\Database;
use App\Utils\View;
use App\Model\Entity\Organization;
use App\Model\Entity\Products;

class Login extends Main
{

    /**
     * Método responsável por retornar os produtos renderizados para a página
     *
     * @return string
     */
    private static function getProductsItems()
    {
        $content = '';
        // PRODUTOS ARRAY COLETADOS DO BANCO
        $results = (new Products('products'))->getProducts('','id DESC');
        $contador = 1;
        // RENDERIZA O ITEM
        while($obProducts=$results->fetchObject(Products::class))
        {
            // DADOS RENDERIZADOS DOS PRODUTOS
            $content.= View::render('pages/Product/ProductTable', [
                'id' => $obProducts->id,
                'product_title' => $obProducts->product_title,
                'product_price' => $obProducts->product_price,
                'product_description' => $obProducts->product_description,
                'product_stoke' => $obProducts->product_stoke,
                'contador' => $contador,
            ]);
            $contador++;
        }

        return $content;
    }

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

        
        $productsRender = self::getProductsItems();


        // ENVIAR CONTEÚDOS RENDERIZADOS PARA MAIN
        return parent::getProductsTable('Área do usuário', $content, $footer, $productsRender);
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

        return self::getLogin();
    }
}
