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
    use Assertions;
    
    protected function tearDown()
    {
        $this->clearLogsFolder();
        
        parent::tearDown();
    }
    
    protected function getPackageProviders($app)
    {
        return [LogsManagerServiceProvider::class];
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
            File::put(storage_path("logs/laravel_dummy_log_{$i}.log"), "Dummy log data");
        }
    }
    
    /**
     * @return void
     */
    protected function clearLogsFolder() : void
    {
        File::cleanDirectory(storage_path("logs"));
    }
}
