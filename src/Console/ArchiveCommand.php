<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;
use ZipArchive;

/**
 * Class ArchiveCommand
 * @package Ludo237\LogsManager\Console
 */
final class ArchiveCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "log:archive";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Archive all the logs and clear the directory";
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "";
    
    /**
     * @var \Illuminate\Support\Carbon
     */
    private $timestamp;
    
    /**
     * @var \ZipArchive
     */
    private $zipArchive;
    
    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $customStoragePath
     */
    public function __construct(?Filesystem $customStoragePath = null)
    {
        $this->timestamp = now()->toDateString();
        
        $this->signature = "log:archive
                            {name=logs_archive : The name of the archive}
                            {--t|timestamp={$this->timestamp} : Include a timestamp in the name}
                            {--remove : Remove the current zip file inside storage/logs with the given name}";
        
        parent::__construct();
        
        $this->setStoragePath($customStoragePath);
        $this->collectLogsFile();
        
        $this->zipArchive = new ZipArchive();
    }
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        if ($this->logs->isEmpty()) {
            $this->warn("Logs folder is empty");
            
            return;
        }
        
        $zipName = $this->argument("name") . "_" . $this->timestamp;
        $zipFilePath = "{$this->storagePath}/{$zipName}.zip";
        
        if ($this->option("remove")) {
            File::delete($zipFilePath);
            
            $this->info("Archive {$zipName} removed from {$this->storagePath}");
            
            return;
        }
        
        if (File::exists($zipFilePath)) {
            $this->error("An archive called {$zipName} already exists in {$this->storagePath}");
            
            return;
        }
        
        $this->createZipArchive($zipName, $zipFilePath);
    }
    
    private function createZipArchive(string $zipName, string $zipFilePath) : void
    {
        if ($this->zipArchive->open($zipFilePath, ZipArchive::CREATE)) {
            
            $this->info("{$zipName} is filling...");
            
            $this->logs->each(function (SplFileInfo $file) use ($zipName) {
                $this->info("Adding {$file->getFilename()} to {$zipName}");
                
                $this->zipArchive->addFile($file->getRealPath(), $file->getBasename());
            });
            
            $this->zipArchive->close();
            
            $this->info("{$zipName} created!");
        }
    }
}