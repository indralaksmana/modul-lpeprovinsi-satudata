<?php namespace Satudata\Lpeprovinsi\Http\Middleware;

use Closure;

/**
 * The LpeprovinsiMiddleware class.
 *
 * @package Satudata\Lpeprovinsi
 * @author  MKI <info@mkitech.net>
 */
class LpeprovinsiMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
