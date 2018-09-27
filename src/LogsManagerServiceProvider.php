<?php

namespace Ludo237\LogsManager;

use Illuminate\Support\ServiceProvider;
use Ludo237\LogsManager\Console\ClearCommand;

/**
 * Class LogsManagerServiceProvider
 * @package Ludo237\LogsManager
 */
final class LogsManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    }
    
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register the service the package provides.
        $this->app->singleton("command.logs.clear", function () {
                return new ClearCommand();
        });

        $this->commands("command.logs.clear");
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["command.logs"];
    }
}