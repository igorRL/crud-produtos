<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Main{

    /**
     * Método responsável por retornar o loading
     * @return string
     */
    
    private static function getLoading(){
        return View::render('pages/layouts/components/loading');
    }

    /**
     * Método responsável por retornar a barra de navegação para desktop
     * @return string
     */
    
    private static function getNavdesktop(){
        return View::render('pages/layouts/components/nav-desktop');
    }

    /**
     * Método responsável por retornar a barra de navegação mobile
     * @return string
     */
    
    private static function getNavmobile(){
        return View::render('pages/layouts/components/nav-mobile');
    }

    /**
     * Método responsável por retornar o footer
     * @return string
     */
    
    private static function getFooter(){
        return View::render('pages/layouts/components/footer');
    }

    /**
     * Método responsável por retornar o conteúdo da página de layout main (principal)
     * @return  string
     */

    public static function getMain($title,$content){
        return View::render('pages/layouts/Main',[
            'title' => $title,
            'loading' => self::getLoading(),
            'nav-desktop' => self::getNavdesktop(),
            'nav-mobile' => self::getNavmobile(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }

}