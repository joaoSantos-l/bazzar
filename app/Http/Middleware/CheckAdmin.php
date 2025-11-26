<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Usuario::where("id", Session('user')['id'])->first();

        if(!$user->admin){
            return redirect()->route('user.show')->with('error', 'Você deve ser admin para acessar essa página!');
        }
        return $next($request);
    }
}
