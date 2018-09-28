<?php

namespace Ludo237\LogsManager\Traits;

use Ludo237\LogsManager\Console\ArchiveCommand;
use Ludo237\LogsManager\Console\ClearCommand;
use Ludo237\LogsManager\Console\DummyCommand;

/**
 * Trait RegisterConsoleCommands
 * @package Ludo237\LogsManager\Traits
 */
trait RegisterConsoleCommands
{
    /**
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
     * Register console commands
     */
    private function registerCommands() : void
    {
        $this->registerArchiveCommand();
        $this->registerClearCommand();
        $this->registerDummyCommand();
    }
    
    /**
     * Build commands
     */
    private function buildCommands() : void
    {
        $this->commands($this->commandsToBuild);
    }
}