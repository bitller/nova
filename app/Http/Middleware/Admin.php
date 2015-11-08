<?php

namespace App\Http\Middleware;

use App\Helpers\Roles;
use Closure;

class Admin {

    /**
     * Roles helper instance.
     *
     * @var Roles
     */
    protected $roles;

    /**
     * @param Roles $roles
     */
    public function __construct(Roles $roles) {
        $this->roles = $roles;
    }

    /**
     * Handle request.
     *
     * @param $request
     * @param callable $next
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next) {
        if ($this->roles->isAdmin()) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        }
        return redirect('/bills');
    }

}