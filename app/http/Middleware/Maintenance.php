<?php

namespace App\Http\Middleware;


class maintenance{
    public function handle($request, $next)
    {
        if(getenv('MAINTENANCE')=='true')
        {
            throw new \Exception("Página me manutenção. Tente novamente mais tarde", 200);
        }
        return $next($request);
    }
}