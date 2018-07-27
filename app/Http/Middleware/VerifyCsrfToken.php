<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except_urls = [
        'depositReceived'
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     * @throws TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        $regex = '#' . implode('|', $this->except_urls) . '#';
        if ($this->isReading($request) || $this->tokensMatch($request) || preg_match($regex, $request->path())) {
            return $this->addCookieToResponse($request, $next($request));
        }
        throw new TokenMismatchException;
    }
}