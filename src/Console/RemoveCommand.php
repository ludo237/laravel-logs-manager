<?php

namespace Ludo237\LogsManager\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class RemoveCommand
 * @package Ludo237\LogsManager\Console
 */
final class RemoveCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "log:remove";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Remove a single log from your storage";
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "log:remove
                            {--a|all : Remove all files}";
    
    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $customStoragePath
     */
    public function __construct(?Filesystem $customStoragePath = null)
    {
        parent::__construct();
        
        $this->setStoragePath($customStoragePath);
        $this->collectLogsFile();
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
        
        if ($this->option("all")) {
            $this->removeAllLogsFile();
        } else {
            $this->determineWhatToRemove();
        }
        
        $this->info("Remove complete");
    }
    
    private function removeAllLogsFile()
    {
        $this->logs->each(function (SplFileInfo $file) {
            File::delete($file->getRealPath());
            $this->info("{$file->getFilename()} removed");
        });
    }
    
    private function determineWhatToRemove()
    {
        $choice = $this->choice(
            "Which log file would you like to remove?",
            $choices = $this->mapChoices()
        );
        
        /** @var SplFileInfo $file */
        $file = $this->logs->filter(function (SplFileInfo $file) use ($choice) {
            return $file->getFilename() === $choice;
        })
            // We need to flat the result of the filter using first()
            ->first();
        
        
        File::delete($file->getRealPath());
        
        $this->info("{$file->getFilename()} removed");
    }
    
    private function mapChoices()
    {
        return $this->logs->map(function (SplFileInfo $file) {
            return $file->getFilename();
        })->toArray();
    }
    
    
}