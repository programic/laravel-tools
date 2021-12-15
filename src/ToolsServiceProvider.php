<?php

namespace Programic\Tools;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Programic\Tools\Middleware\SentryContext;

class ToolsServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $kernel->pushMiddleware(SentryContext::class);
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
