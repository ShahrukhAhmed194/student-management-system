<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Allow sql_require_primary_key
        Event::listen(MigrationsStarted::class, function () {
            if (config('database.allow_disabled_pk')) {
                DB::statement('SET SESSION sql_require_primary_key=0');
            }
        });

        Event::listen(MigrationsEnded::class, function () {
            if (config('database.allow_disabled_pk')) {
                DB::statement('SET SESSION sql_require_primary_key=1');
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
