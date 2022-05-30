<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;
use App\Model\Entity\Products;

class Home extends Main
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
        $results = (new Products('products'))->getProducts('enable=true','id DESC');
        $contador = 1;
        // RENDERIZA O ITEM
        while($obProducts=$results->fetchObject(Products::class))
        {
            $serializa_images = $obProducts->product_images;
            $unserializedData = unserialize($serializa_images);
            $principalImage = $unserializedData[0];
            $principalImageSrc = "/public/img/products/h-220px-".$principalImage;

            // DADOS RENDERIZADOS DOS PRODUTOS
            $content.= View::render('pages/Product/Product', [
                'id' => $obProducts->id,
                'product_title' => $obProducts->product_title,
                'product_price' => $obProducts->product_price,
                'product_description' => $obProducts->product_description,
                'product_stoke' => $obProducts->product_stoke,
                'image_src' => $principalImageSrc,
                'contador' => $contador
            ]);
            $contador++;
        }

        return $content;
    }

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


        $productsRender = self::getProductsItems();

        // ENVIAR CONTEÚDOS RENDERIZADOS PARA MAIN
        return parent::getProductsList('Bem vindo!', $content, $footer, $productsRender);
    }
}
