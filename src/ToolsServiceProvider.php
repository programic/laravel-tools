<?php

namespace Programic\Tools;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class ToolsServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $kernel->pushMiddleware(Programic\Tools\Middleware\SentryContext::class);
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
