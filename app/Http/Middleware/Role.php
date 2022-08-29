<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {

        if (Auth::user()->user_role->role->name === $role) {
            return $next($request);
        }

        abort(403, "Anda tidka memiliki akses untuk melihat halaman ini");
        // if ($role === 'customer') {
        //     return redirect()->route('customer.home');
        // }

        // if ($role === 'cashier') {
        //     return redirect()->route('cashier.home');
        // }

        // if ($role === 'manager') {
        //     return redirect()->route('manager.home');
        // }
        // return $next($request);
    }
}
