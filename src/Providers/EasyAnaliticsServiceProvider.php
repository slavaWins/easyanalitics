<?php

namespace SlavaWins\EasyAnalitics\Providers;

use Illuminate\Support\ServiceProvider;
use SlavaWins\EasyAnalitics\Console\Commands\GenereateExample;

class EasyAnaliticsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$loader = \Illuminate\Foundation\AliasLoader::getInstance();
       // $loader->alias("FElement");
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenereateExample::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'easyanalitics');


        $this->publishes([
            __DIR__.'/../database/migrations' =>  database_path('migrations'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/views/example' =>  resource_path('views/easyanalitics'),
        ], 'public');

    }
}
