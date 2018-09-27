<?php

namespace Ludo237\LogsManager;

use Illuminate\Support\ServiceProvider;
use Ludo237\LogsManager\Console\ArchiveCommand;
use Ludo237\LogsManager\Console\ClearCommand;
use Ludo237\LogsManager\Console\DummyCommand;

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
        $this->registerArchiveCommand();
        $this->registerClearCommand();
        $this->registerDummyCommand();
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
    
    /**
     * Register the logs:archive command
     *
     * @return void
     */
    public function registerArchiveCommand() : void
    {
        $this->app->singleton("command.log.archive", function () {
            return new ArchiveCommand();
        });
        
        $this->commands("command.log.archive");
    }
    
    /**
     * Register the logs:clear command
     *
     * @return void
     */
    private function registerClearCommand() : void
    {
        $this->app->singleton("command.log.clear", function () {
            return new ClearCommand();
        });
        
        $this->commands("command.log.clear");
    }
    
    /**
     * Register the logs:dummy command
     *
     * @return void
     */
    private function registerDummyCommand() : void
    {
        $this->app->singleton("command.log.dummy", function () {
            return new DummyCommand();
        });
        
        $this->commands("command.log.dummy");
    }
}