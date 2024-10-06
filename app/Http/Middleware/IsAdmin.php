<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use App\Traits\HasResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    use HasResponse;
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->roles()->pluck('name')->contains(UserRoleEnum::admin->value)) {
            return $next($request);
        }
        return $this->unauthorized();
    }
}
