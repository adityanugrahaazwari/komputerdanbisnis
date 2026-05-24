<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), megaphone=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), payment=()');

        // Strict-Transport-Security (HSTS) - only for HTTPS
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Content-Security-Policy (CSP)
        // Note: This is a base policy. Adjusted to allow common CDNs used in this project.
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com; ";
        $csp .= "img-src 'self' data: https:; ";
        $csp .= "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; ";
        $csp .= "connect-src 'self'; ";
        $csp .= "frame-src 'self'; ";
        $csp .= "object-src 'none';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
