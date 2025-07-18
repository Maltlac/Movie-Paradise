<?php

namespace App\Http\Middleware;

use auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
     /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
            if ($this->auth->getUser()->role !== "admin") {
                abort(404, 'NOT FOUND');
            }
    
            return $next($request);
        
    }
}
