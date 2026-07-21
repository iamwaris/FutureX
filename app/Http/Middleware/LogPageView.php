<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lightweight first-party page-view log for the admin Traffic widget —
 * intentionally separate from GA4/Clarity (those track the full client-side
 * picture but need external API access to read back into Filament; this
 * gives the dashboard something real to show without that dependency).
 */
class LogPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            PageView::create([
                'path' => $request->path(),
                'viewed_at' => now(),
            ]);
        }

        return $response;
    }
}
