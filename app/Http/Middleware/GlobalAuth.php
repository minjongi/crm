<?php

namespace App\Http\Middleware;

use App\Exceptions\ApplicationException;
use Closure;

class GlobalAuth extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string[] ...$guards
     *
     * @return mixed
     * @throws ApplicationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $excludedUriByAuth = [
            'pages/login',
            'logout',
            'api/logout',
            'api/login',
            'api/register'
        ];

        $accessDeniedUriByAuth = [
            'pages/login',
            'pages/register'
        ];

        if ($this->auth->check() && $request->is($accessDeniedUriByAuth)) {
            return redirect('/');
        }

        if ($this->auth->check() or $request->is($excludedUriByAuth)) {
            return $next($request);
        }

        if ($request->ajax()) {
            throw new ApplicationException(ApplicationException::UNAUTHENTICATED);
        }

        return redirect()->guest('pages/login');
    }
}
