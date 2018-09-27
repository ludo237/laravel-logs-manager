<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

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
     * Set the current storagePath to either a custom one or a default from laravel
     *
     * @param \Illuminate\Filesystem\Filesystem $customStoragePath
     * @return void
     */
    protected function setStoragePath(?Filesystem $customStoragePath) : void
    {
        $this->storagePath = $customStoragePath ?? storage_path("logs");
    }
    
    /**
     * Collect all the logs inside the storagePath variable that we have
     *
     * @return void
     */
    protected function collectLogsFile() : void
    {
        $this->logs = collect(File::files($this->storagePath));
    }
}