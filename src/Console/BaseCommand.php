<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

/**
 * Class BaseCommand
 * @package Ludo237\LogsManager\Console
 */
abstract class BaseCommand extends Command
{
    use ConfirmableTrait;
    
    /**
     * Path of the current laravel installation
     *
     * @var string
     */
    public $storagePath;
    
    /**
     * Collection of files inside the $storagePath
     *
     * @var \Illuminate\Support\Collection
     */
    public $logs;
    
    /**
     * Determine if the specified folder has logs in it
     * if not, the command will exit
     */
    protected function checkLogsPresence()
    {
        if ($this->logs->isEmpty()) {
            $this->warn("Logs folder is empty");
            
            exit;
        }
    }
    
    /**
     * If a command need the confirmation this method
     * will allow that
     */
    protected function askForConfirmation()
    {
        if (!$this->confirmToProceed("There are {$this->logs->count()} files, do you want to remove them?")) {
            exit;
        }
    }
}