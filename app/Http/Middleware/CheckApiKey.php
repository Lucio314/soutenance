<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $unique_code = $request->header('api_key');
        $application = Application::where('unique_code', $unique_code)->first();

        if (!$unique_code || !$application) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Si vous souhaitez passer l'application au contrôleur, vous pouvez l'ajouter dans la requête.
        $request->attributes->set('application', $application);

        return $next($request);
    }
}
