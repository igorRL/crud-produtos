<?php

namespace App\Http\Middleware;

class queue{

    private static $map = [];

    /**
     * Mapeamento dos middleares que serão caregados e todas as rotas
     *
     * @var [type]
     */
    private static $default;


    private $middlewares = [];
    private $controller;
    private $controllerArgs = [];

    

    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default,$middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    public static function setMap($map){
        self::$map = $map;
    }

    public static function setDefault($default){
        self::$default = $default;
    }

    public function next($request)
    {
        // VERIFICA SE A FILA ESTÁ VAZIA
        if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        $middleware = array_shift($this->middlewares);

        // VERIFICA MAPEAMENTO
        if(!isset(self::$map[$middleware]))
        {
            throw new \Exception("Problema ao processar o middleware da requisição", 500);
            
        }

        $queue = $this;
        $next = function($request) use ($queue){
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request,$next);
    }
}