<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

/**
 * Class DummyCommand
 * @package Ludo237\LogsManager\Console
 */
final class DummyCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "log:dummy";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new set of dummy logs file";
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "log:dummy
                            {name=laravel_dummy_log : File name used for the dummy logs creation}
                            {--quantity=1 : Quantity of dummy logs that you want}";
    
    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $customStoragePath
     */
    public function __construct(?Filesystem $customStoragePath = null)
    {
        parent::__construct();
        
        $this->setStoragePath($customStoragePath);
    }
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $baseFileName = $this->argument("name");
        $quantity = $this->option("quantity");
        
        for ($i = 0; $i < $quantity; $i++) {
            $logFileName = "{$baseFileName}_{$i}.log";
            File::put("{$this->storagePath}/{$logFileName}", "Dummy log file number {$i}");
        }
        
        if ($baseFileName === "laravel_dummy_log") {
            $this->info("{$quantity} dummy files have been created");
        } else {
            $this->info("{$quantity} dummy files named {$baseFileName} have been created");
        }
    }
}