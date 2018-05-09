<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {

                return response('Unauthorized.', 401);
            } 
            else {

                return redirect()->route('login')
                ->with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Access Denied You Must Be Logged In.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
        }

        return $next($request);
    }
}
