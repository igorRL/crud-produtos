<?php

namespace App\Utils;

class View{

    /**
     * Variaveis padões da view
     *
     * @var array
     */
    private static $vars = [];


    /**
     * Método responsavel por definir os métodos responsáveis da classe
     *
     * @param array $vars
     */
    public static function init($vars)
    {
        self::$vars = $vars;
    }


    /**
    *Método responsável por retornar o conteúdo de uma view
    *@param string $view
    *@return string
    */

    private static function getContentView($view)
    {
        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }


    /**
     * Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */


    public static function render($view,$vars = [])
    {
        // Conteúdo da view
        $contentView = self::getContentView($view);


        // Merge das variáveis da view
        $vars = array_merge(self::$vars,$vars);


        // Descobrir as chaves dos arrays de variaveis recebidas
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        // retorna o conteúdo renderizado
        return str_replace($keys,array_values($vars),$contentView);
    }

}