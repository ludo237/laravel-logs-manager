<?php

namespace Ludo237\LogsManager\Tests;

use Illuminate\Support\Facades\File;
use Ludo237\LogsManager\LogsManagerServiceProvider;
use Orchestra\Testbench\TestCase as OTestCase;

/**
 * TestCase
 * @package Ludo237\LogsManager\Tests
 */
abstract class TestCase extends OTestCase
{
    protected function getPackageProviders($app)
    {
        return [LogsManagerServiceProvider::class];
    }
    
    /**
     * Wrapper to assert the count of files inside the storage folder
     *
     * @param int $count
     */
    protected function assertLogsFolderFilesCount(int $count = 5) : void
    {
        $files = File::files(storage_path("logs"));
        $this->assertCount($count, $files);
    }
    
    /**
     * Ensure that the folder in storage/logs is
     * populated with dummy data
     *
     * @param int $numberOfLogs
     * @return void
     */
    protected function populateLogsFolder(int $numberOfLogs = 5) : void
    {
        for ($i = 0; $i < $numberOfLogs; $i++) {
            File::put(storage_path("logs/laravel_foobar_{$i}.log"), "Dummy log data");
        }
    }
}
