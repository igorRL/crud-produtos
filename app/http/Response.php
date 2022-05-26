<?php

namespace App\Http;

class Response{

    /**
     * Código do status http
     *
     * @var integer
     */ 
    private $httpCode = 200;

    /**
     * Cabeçalho do response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que está sendo retornado
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do response
     *
     * @var mixed
     */
    private $content;
}