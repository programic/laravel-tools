<?php

namespace Programic\Tools;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class Mysql8ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Check this one here https://github.com/laravel/framework/issues/33238#issuecomment-897063577
        Event::listen(MigrationsStarted::class, function () {
            DB::statement('SET SESSION sql_require_primary_key=0');
        });

        Event::listen(MigrationsEnded::class, function () {
            DB::statement('SET SESSION sql_require_primary_key=1');
        });
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
