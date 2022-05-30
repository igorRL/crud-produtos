<?php

    namespace App\http;

    class Request{

        /**
         * Instancia da rota
         *
         * @var Router
         */
        private $router;

        /**
         * Método http da requisição
         * @var string
         */
        private $httpMethod;


        /**
         * url da página
         * @var string
         */
        private $uri;

        /**
         * Paramentros da url ($_GET)
         *
         * @var array
         */
        private $queryParams = [];

        /**
         * Variaveis recebidas do post da página ($_Post)
         *
         * @var array
         */
        private $postVars = [];

        /**
         * Variaveis recebidas do post da página ($_Post)
         *
         * @var array
         */
        private $files = [];

        /**
         * Cabeçalhos da requisição
         *
         * @var array
         */
        private $headers = [];

        /**
         * construtor da classe
         */
        public function __construct($router)
        {
            $this->router = $router;
            $this->queryParams = $_GET ?? [];
            $this->postVars = $_POST ?? [];
            $this->files = $_FILES ?? [];
            $this->headers = getallheaders();
            $this->httpMethod = $_SERVER['REQUEST_METHOD'];
            $this->setUri();
        }

        /**
         * Método responsável por retornar a instancia de Router
         *  
         * @return Router
         */
        public function getRouter()
        {
            return $this->router;
        }

        /**
         * Método responsável por definir a URI
         *  
         */
        private function setUri()
        {
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';

            $xURI = explode('?',$this->uri);
            $this->uri = $xURI[0];
        }

        /**
         * Método responsável por retornar o HTTP da requisição
         *
         * @return string
         */
        public function getHttpMethod(){
            return $this->httpMethod;
        }

        /**
         * Método responsável por retornar o uri da requisição
         *
         * @return string
         */
        public function getUri(){
            return $this->uri;
        }

        /**
         * Método responsável por retornar os headers da página
         *
         * @return array
         */
        public function getHeaders(){
            return $this->headers;
        }

        /**
         * Método responsável por retornar os GETs da página
         *
         * @return array
         */
        public function getQueryParams(){
            return $this->queryParams;
        }

        /**
         * Método responsável por retornar os POSTs da página
         *
         * @return array
         */
        public function getPostVars(){
            return $this->postVars;
        }

        /**
         * Método responsável por retornar os POSTs da página
         *
         * @return array
         */
        public function getFiles(){
            return $this->files;
        }
    }