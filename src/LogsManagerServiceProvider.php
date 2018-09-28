<?php

namespace Ludo237\LogsManager;

use Illuminate\Support\ServiceProvider;
use Ludo237\LogsManager\Traits\RegisterConsoleCommands;

/**
 * Class LogsManagerServiceProvider
 * @package Ludo237\LogsManager
 */
final class LogsManagerServiceProvider extends ServiceProvider
{
    use RegisterConsoleCommands;
    
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
        $this->registerCommands();
        $this->buildCommands();
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["command.log"];
    }
}