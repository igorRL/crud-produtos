<?php

namespace App\Common;


class Environment{

    /**
     * Método responsável por carregar as variaveis de ambiente do projeto
     *
     * @param string $dir Caminho absoluto onde encontra-se o arquivo .env
     */
    public static function load($dir)
    {
        // Verifica se o arquivo .env existe
        if(!file_exists($dir.'/.env')){
            return false;
        }

        // define as variaveis de ambiente
        $lines = file($dir.'/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }
    }

}