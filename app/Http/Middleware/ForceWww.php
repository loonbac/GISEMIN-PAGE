<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceWww
{
    /**
     * Redirect non-www public domain to www, excluding admin domain.
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $adminHost = config('app.admin_domain', 'admin.gisemin.com');

        if ($host === 'gisemin.com' && $host !== $adminHost) {
            $target = $request->getScheme().'://www.gisemin.com'.$request->getRequestUri();
            return redirect()->to($target, 301);
        }

        return $next($request);
    }
}
