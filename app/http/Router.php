<?php

namespace App\Http;

// Closure é um método executável (importa o objeto indicado pela url da página e seu conteúdo)
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router{

    /**
     * Url completa do projeto (raiz)
     *
     * @var string
     */
    private $url = '';


    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    
    /**
     * Índice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instância de request
     *
     * @var Request
     */
    private $request;


    /**
     * Método responsável por enviar a classe
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url     = $url;
        $this->setPrefix();
    }


    /**
     * Método responsável por definir o prefixo das rotas
     *
     */
    public function setPrefix()
    {
        // informações da URL atual
        $parseUrl = parse_url($this->url);
        

        // Definir o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }


    
    
    // definindo as rotas para os métodos http (GET, POST, PUT, DELETE)



    /**
     * Método responsável por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {      
        
        
        // validação dos parametros
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }


        // VARIAVEIS DA ROTA
        $params['variables'] = [];


        // PADRÃO DE VALIDAÇÃO DAS VARIAVEIS
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable,$route,$matches)){
            $route = preg_replace($patternVariable,'(.*?)',$route);
            $params['variables'] = $matches[1];
        }

        // Criando um pardrão para validar a rota
        $patternRoute = '/^'.str_replace('/','\/',$route).'$/';

        // adicinando a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

    }
    
    
    /**
     * Método responável por definir uma rota de GET
     *
     * @param string $route 
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET',$route,$params);
    }
    
    
    /**
     * Método responável por definir uma rota de POST
     *
     * @param string $route 
     * @param array $params
     */
    public function post($route,$params = [])
    {
        return $this->addRoute('POST',$route,$params);
    }
    
    
    /**
     * Método responável por definir uma rota de PUT (alterações)
     *
     * @param string $route
     * @param array $params
     */
    public function put($route,$params=[])
    {
        return $this->addRoute('PUT',$route,$params);
    }
    
    
    /**
     * Método responável por definir uma rota de DELETE
     *
     * @param string $route 
     * @param array $params
     */
    public function delete($route,$params=[])
    {
        return $this->addRoute('DELETE',$route,$params);
    }


    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     * 
     * @return string
     */
    private function getUri()
    {
        $uri = $this->request->getUri();
        // Fatia a uri com o prefixo

        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];

        // Retorna a uri sem prefixo
        return end($xUri);
    }


    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return array
     */
    private function getRoute()
    {
        // Retornar a uri da página sem o prefixo
        $uri = $this->getUri();

        // Retornar o método da requisição
        $httpMethod = $this->request->getHttpMethod();    
        
        // Valida as rotas forech as padrao das rotas = metodo das rotas
        foreach($this->routes as $patternRoute=>$methods){
            
            // verificar se a URI bate com o padrão
            if(preg_match($patternRoute,$uri,$matches)){
                // Verifica o método
                if(isset($methods[$httpMethod])){
                    unset($matches[0]);

                    // VARIAVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    // COMBINAR AS CHAVES
                    $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                    // ADICIONANDO AS REQUESTS
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    // retorno dos paramentros da rota
                    return $methods[$httpMethod];
                }

                // Se o parametro da URL não for encontrado, o método retorna como não permitido/não definido
                throw new Exception("Método não permitido", 405);
            }
        }

        // url não encontrada
        throw new \Exception("URL não encontrada", 404);
    }


    /**
     * Método responsável por executar a rota atual
     *
     * @return Response
     */
    public function run()
    {
        try {
            // throw new Exception("Página não encontrada", 404); //simulando um erro 404

            //obter a rota atual
            $route = $this->getRoute();


            // verifica o controlador
            if(!isset($route['controller'])){
                throw new Exception("A URL não pode ser processada", 500);
            }

            // argumentos da função
            $args = [];

            // REFLETION
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';

            }

            // retorna a execussão da função
            return call_user_func_array($route['controller'],$args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
