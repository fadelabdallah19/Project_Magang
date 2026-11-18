<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanManageInventory
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->canManageInventory()) {
            abort(403, 'Anda hanya memiliki akses melihat data.');
        }
        return $next($request);
    }
}
