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

    /**
     * Método responsável por iniciar as classes e definir os valores
     *
     * @param interger $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode,$content,$contentType='text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }
    
    /**
     * Método responsável por alterar o content type do Response
     *
     * @param [type] $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type',$contentType);
    }

    /**
     * Método responsável por adicionar um registro no response
     *
     * @param string $key
     * @param string $value
     */
    public function addHeader($key,$value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        // enviar Headers
        foreach($this->headers as $key=>$value){
            header($key.": ".$value);
        }
    }

    /**
     * Método responsável or enviar a resposta para o usuário
     *
     */
    public function sendResponse()
    {
        // enviar os headers
        $this->sendHeaders();

        // imprimir o conteúdo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}