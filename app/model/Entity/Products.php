<?php

namespace App\Model\Entity;

use App\Db\Database;

/**
 * Classe responsável pelo CRUD
 */
class Products{
    /**
     * Id da tabela (unico)
     *
     * @var number
     */
    public $id;

    /**
     * Id definido pelo usuário
     *
     * @var string
     */
    public $productId;

    /**
     * Estoque do produto
     *
     * @var number
     */
    public $productStoke;

    /**
     * Preço do produto
     *
     * @var string
     */
    public $productPrice;

    /**
     * Título do produto
     *
     * @var string
     */
    public $productTitle;

    /**
     * Descrição do produto
     *
     * @var string
     */
    public $productDescription;

    /**
     * Array serializada que contem os srcs das imagens
     * @var array
     */
    public $productImages;

    /**
     * variavel que informa se o upload dos dados foi executado com sucesso
     * @var boolean
     */
    public $insertData = false;

    /**
     *  variavel que informa se o upload das imagens foi executado com sucesso
     * @var boolean
     */
    public $uploadStatus = false;

    /**
     * Método responsável por cadastrar um novo produto
     *
     * @return boolean
     */
    public function register()
    {
        $this->id = (new Database('products'))->insert([
            'product_id'=>$this->productId,
            'product_title'=>$this->productTitle,
            'product_description'=>$this->productDescription,
            'product_stoke'=>$this->productStoke,
            'product_price'=>$this->productPrice
        ]);
        $this->insertData = true;
        return $this->insertData;
    }

    /**
     * Método responsável por fazer o upload das imagens
     *
     * @return boolean
     */
    public function upLoadFiles()
    {
        $this->uploadStatus =  (new Database('products'))->upLoadFiles([
            'id' => $this->id,
            'files' => $this->productImages
        ]);
        $this->uploadStatus = true;
    }


    /**
     * Método responsável por retornar os produtos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getProducts($where = 'enable=1', $order = '', $limit = '', $fields = "*" )
    {
        return (new Database('products'))->select($where, $order, $limit, $fields);
    }

}
