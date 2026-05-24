<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('get') && !$request->ajax()) {
            $ip = $request->ip();
            $today = now()->toDateString();

            // Only record if this IP hasn't visited today
            $exists = Visitor::where('ip_address', $ip)
                ->where('visit_date', $today)
                ->exists();

            if (!$exists) {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $request->userAgent(),
                    'page_url' => $request->fullUrl(),
                    'visit_date' => $today,
                ]);
            }
        }

        return $next($request);
    }
}
