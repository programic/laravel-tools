<?php

namespace Programic\Tools;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Programic\Tools\Middleware\SentryContext;

class ToolsServiceProvider extends ServiceProvider
{
    const VERSION = 1.1;
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
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register magic
    }
}
