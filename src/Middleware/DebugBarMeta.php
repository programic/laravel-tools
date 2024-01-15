<?php

namespace Programic\Tools\Middleware;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\JsonResponse;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class DebugBarMeta
{
    public function handle($request, Closure $next): Response
    {
        if (! Debugbar::isEnabled()) {
            return $next($request);
        }

        /** @var JsonResponse $response */
        $response = $next($request);

        $data = $response->getData();

        $debugData = new \StdClass;
        $debugData->debugbar = Debugbar::collect();

        if (isset($data->meta)) {
            $data->meta->debugbar = $debugData->debugbar;
        } else {
            $data->meta = $debugData;
        }

        $response->setData($data);

        return $response;
    }
}
