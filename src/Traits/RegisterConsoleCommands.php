<?php

namespace Ludo237\LogsManager\Traits;

use Ludo237\LogsManager\Console\ArchiveCommand;
use Ludo237\LogsManager\Console\ClearCommand;
use Ludo237\LogsManager\Console\DummyCommand;
use Ludo237\LogsManager\Console\ListCommand;
use Ludo237\LogsManager\Console\RemoveCommand;

/**
 * Trait RegisterConsoleCommands
 * @package Ludo237\LogsManager\Traits
 */
trait RegisterConsoleCommands
{
    /**
     * An array of available commands
     *
     * @var array
     */
    protected $commandsToBuild = [];
    
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
        
        array_push($this->commandsToBuild, "command.log.archive");
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
        
        array_push($this->commandsToBuild, "command.log.clear");
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
        
        array_push($this->commandsToBuild, "command.log.dummy");
    }
    
    /**
     * Register the logs:list command
     *
     * @return void
     */
    private function registerListCommand() : void
    {
        $this->app->singleton("command.log.list", function () {
            return new ListCommand();
        });
        
        array_push($this->commandsToBuild, "command.log.list");
    }
    
    /**
     * Register the logs:remove command
     *
     * @return void
     */
    private function registerRemoveCommand() : void
    {
        $this->app->singleton("command.log.remove", function () {
            return new RemoveCommand();
        });
        
        array_push($this->commandsToBuild, "command.log.remove");
    }
    
    /**
     * Register all console commands
     */
    private function registerCommands() : void
    {
        $this->registerArchiveCommand();
        $this->registerClearCommand();
        $this->registerDummyCommand();
        $this->registerListCommand();
        $this->registerRemoveCommand();
    }
    
    /**
     * Build all console commands
     */
    private function buildCommands() : void
    {
        $this->commands($this->commandsToBuild);
    }
}