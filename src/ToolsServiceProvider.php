<?php

namespace Programic\Tools;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Programic\Tools\Middleware\SentryContext;

class ToolsServiceProvider extends ServiceProvider
{
    const VERSION = 3.0;
    private $middlewareGroups = ['web', 'api'];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        foreach ($this->middlewareGroups as $group) {
            if ($router->hasMiddlewareGroup($group)) {
                $router->pushMiddlewareToGroup($group, SentryContext::class);
            }
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/debugbar.php' => config_path('debugbar.php'),
            ], 'debugbar-config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
