<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ClearCommand
 *
 * @package Ludo237\LogsManager\Console
 */
class ClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "logs:clear";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Clear the logs located in storage/logs folder";
    
    /** @var string */
    private $storage_path;
    
    /** @var \Illuminate\Support\Collection */
    private $logs;
    
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->storage_path = storage_path("logs");
        
        $this->logs = collect(File::files($this->storage_path));
    }
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->logs->isEmpty()) {
            $this->warn("Logs folder is empty");
            
            return;
        }
        
        if (!$this->confirm("There are {$this->logs->count()} files, do you want to remove them?")) {
            $this->performCleanUp();
        } else {
            $this->line("Cleanup aborted!");
        }
    }
    
    private function performCleanUp()
    {
        $this->logs->each(function (SplFileInfo $file) {
            $this->info("Removing {$file->getFilename()}....");
            File::delete($file->getRealPath());
        });
    }
}
