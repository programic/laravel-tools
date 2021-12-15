<?php

namespace Programic\Tools\Middleware;

use Closure;

class SentryContext
{
    public function handle($request, Closure $next)
    {
        if (app()->bound('sentry')) {
            app('sentry')->configureScope(function (\Sentry\State\Scope $scope) {
                if (auth()->check()) {
                    $user = auth()->user();

                    $scope->setUser([
                        'id' => $user->id,
                        'email' => $user->email,
                        'plan' => $user->plan
                    ]);
                }

                $scope
                    ->setTags([
                        'laravel' => app()->version(),
                    ]);

            });
        }

        return $next($request);
    }
}
