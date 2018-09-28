<?php

namespace Ludo237\LogsManager\Console;

use Exception;
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
     * Archive that will be created
     *
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
        $timestamp = now()->toDateString();
        
        $this->signature = "log:archive
                            {name=logs_archive_{$timestamp} : The name of the archive}
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
     * @throws \Ludo237\LogsManager\Exceptions\LogsFolderEmptyException
     */
    public function handle() : void
    {
        $this->checkIfFolderIsEmpty();
        
        $zipName = $this->argument("name") . ".zip";
        $zipFilePath = "{$this->storagePath}/{$zipName}";
        
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
    
    /**
     * Core of the command where we actually create the archive
     *
     * @param string $zipName
     * @param string $zipFilePath
     * @throws \Exception
     */
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
        } else {
            throw new Exception("Cannot create {$zipName} archive right now");
        }
    }
}