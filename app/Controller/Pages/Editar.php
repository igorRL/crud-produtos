<?php

namespace App\Controller\Pages;

use App\Db\Database;
use App\Utils\View;
use App\Model\Entity\Organization;
use App\Model\Entity\Products;

class Editar extends Main
{
    private static function getProductsItem()
    {
        $id = $_GET['id'];
        $content = '';
        // PRODUTOS ARRAY COLETADOS DO BANCO
        $results = (new Products('products'))->getProducts("id='$id'",'id DESC');
        $contador = 1;
        // RENDERIZA O ITEM
        while($obProducts=$results->fetchObject(Products::class))
        {
            // DADOS RENDERIZADOS DOS PRODUTOS
            $content.= View::render('pages/editar', [
                'id' => $obProducts->id,
                'product_title' => $obProducts->product_title,
                'product_price' => $obProducts->product_price,
                'product_description' => $obProducts->product_description,
                'product_stoke' => $obProducts->product_stoke,
                'contador' => $contador,
                'URL' => URL
            ]);
            $contador++;
        }

        return $content;
    }

    /**
     * Método responsável por retornar o conteúdo (view) da home
     * @return  string
     */
    public static function getEditar()
    {

        
        // RECUPERANDO O OBJETO COM AS INFORMAÇÔES DA ORGANIZAÇÂO
        $obOrganization = new Organization;


        // // DADOS RENDERIZADOS DO CONTEÚDO DA PÀGINA
        // $content = View::render('pages/editar', [
        //     'organization-name' => $obOrganization->name,
        //     'organization-description' => $obOrganization->description,
        //     'organization-site' => $obOrganization->site
        // ]);


        // DADOS RENDERIZADOS DO FOOTHER DA PÁGINA
        $footer = View::render('pages/layouts/components/footer', [
            'organization-name' => $obOrganization->name,
            'organization-description' => $obOrganization->description,
            'organization-site' => $obOrganization->site,
            'date-year' =>date('Y'),
        ]);


        $content = self::getProductsItem();


        // ENVIAR CONTEÚDOS RENDERIZADOS PARA MAIN
        return parent::getMain('Área do usuário', $content, $footer);
    }



    /**
     * Método resonsável por cadastrar um novo produto
     *
     * @param request $request
     * @return string
     */
    public static function updateProduct($request)
    {
        // DADOS DO POST VARS
        $postVars = $request->getPostVars();
        $files = $request->getFiles();
        $id = $postVars['id'];
        $productId = $postVars['product-id'];
        $productStoke = $postVars['product-stoke'];
        $productTitle = $postVars['product-title'];
        $productDescription = $postVars['product-description'];
        $productPrice = $postVars['product-price'];
        $productImages = $files['product-images'];

        $conn = mysqli_connect('localhost', 'root', 'root', 'crud-products');
        $sql = "UPDATE products SET product_id='$productId', product_title='$productTitle', product_description='$productDescription', product_stoke='$productStoke', product_price='$productPrice' WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            $obProduct = new Products;
            $obProduct->productId = $postVars['id'];
            $obProduct->productImages = $files['product-images'];
            $obProduct->upLoadFiles();
        }
        
        return self::getEditar();
    }
}
