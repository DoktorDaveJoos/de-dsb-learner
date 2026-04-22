<?php

namespace App\Http\Middleware;

use App\Pulse\AnonymousVisitor;
use Closure;
use Illuminate\Http\Request;
use Laravel\Pulse\Facades\Pulse;
use Symfony\Component\HttpFoundation\Response;

class TrackPulseVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession()) {
            Pulse::rememberUser(new AnonymousVisitor($request->session()->getId()));
        }

        return $next($request);
    }
}
