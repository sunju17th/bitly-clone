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

        // 1. Chống Clickjacking (Không cho phép nhúng website vào thẻ iframe)
        $response->headers->set('X-Frame-Options', 'DENY');

        // 2. Chống XSS (Cross-Site Scripting)
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Bảo vệ Referrer (Chỉ gửi domain gốc, không gửi full URL khi click link ra ngoài)
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 4. Content Security Policy (CSP) - Cái này là mạnh nhất để chống Inject code từ F12
        // Chỉ cho phép script chạy từ chính domain này (self) và các nguồn tin cậy.
        // nonce được dùng để cho phép inline script cụ thể
        $response->headers->set('Content-Security-Policy', "default-src 'self' http: https: data: blob: 'unsafe-inline' 'unsafe-eval'; frame-ancestors 'none';");

        return $response;
    }
}
