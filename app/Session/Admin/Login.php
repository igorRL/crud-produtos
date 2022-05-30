<?php

namespace App\Session\Admin;

class Login
{


    private static function init()
    {
        if(session_start()!=PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }



    public static function login($obUser)
    {

        $_SESSION['admin']['usuario'] = [
            'id'=> $obUser->id,
            'nome'=> $obUser->nome,
            'email'=> $obUser->email
        ];
    }
}