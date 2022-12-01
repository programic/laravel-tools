<?php

namespace Programic\Tools;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Programic\Tools\Console\Commands\SendQueueAnalyticsCommand;
use Programic\Tools\Contracts\AnalyticsClient;
use Programic\Tools\Contracts\QueueSummary;
use Programic\Tools\Controllers\ToolsController;
use Programic\Tools\Middleware\SentryContext;
use Programic\Tools\Services\Analytics\Databox;

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

        $this->app->bind(QueueSummary::class, function () {
            $instance = 'Programic\Tools\Services\Queue\\' . ucfirst(config('queue.default')). 'QueueService';
            if (class_exists($instance)) {
                return new $instance();
            }

            throw new \ErrorException(ucfirst(config('queue.default')) . ' queue health check not supported');
        });

        $this->app['router']->get('ohdear-health-check', [ToolsController::class, 'ohdear']);

        $databoxToken = config('services.databox.token');

        if ($databoxToken) {
            $this->app->singleton(AnalyticsClient::class, fn () => new Databox($databoxToken));

            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command(SendQueueAnalyticsCommand::class)->everyMinute()->withoutOverlapping();
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
           SendQueueAnalyticsCommand::class,
        ]);
    }
}
