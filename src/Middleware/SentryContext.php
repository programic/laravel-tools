<?php

namespace Programic\Tools\Middleware;

use Sentry\State\Scope;
use Programic\Tools\ToolsServiceProvider;
use Closure;

class SentryContext
{
    public function handle($request, Closure $next)
    {
        if (app()->bound('sentry')) {
            app('sentry')->configureScope(function (Scope $scope) {
                if (auth()->check()) {
                    $user = auth()->user();

                    $scope->setUser([
                        'id' => $user->id,
                        'email' => $user->email,
                    ]);
                }

                $scope
                    ->setContext('Laravel', [
                        'version' => app()->version(),
                        'Tools version' => ToolsServiceProvider::VERSION,
                    ]);

            });
        }

        return $next($request);
    }
}
