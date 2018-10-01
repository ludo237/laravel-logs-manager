<?php

namespace Ludo237\LogsManager\Console;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ListCommand
 * @package Ludo237\LogsManager\Console
 */
final class ListCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "log:list";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get a clear view of the content of your log folder";
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "log:list";
    
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
        
        $files = $this->logs->map(function (SplFileInfo $file) {
            $createdAt = Carbon::createFromTimestamp($file->getCTime())->toDateTimeString();
            $updatedAt = Carbon::createFromTimestamp($file->getMTime())->toDateTimeString();
            
            return [$file->getFilename(), $createdAt, $updatedAt];
        })->toArray();
        
        $this->table(
            ["File", "Created At", "Last Update"],
            $files
        );
    }
}