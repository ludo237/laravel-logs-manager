<?php

namespace Ludo237\LogsManager\Tests;

use Illuminate\Support\Facades\File;

/**
 * Trait Assertions
 * @package Ludo237\LogsManager\Tests
 */
trait Assertions
{
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
     * Determine if the current storage path contains a .zip folder
     *
     * @param null|string $zipName
     */
    protected function assertLogsFolderContainsZip(?string $zipName = null) : void
    {
        $now = now()->toDateString();
        $zipName = $zipName ?? "logs_archive_{$now}.zip";
        $hasZip = File::exists(storage_path("logs/{$zipName}"));
        
        $this->assertTrue($hasZip);
    }
    
    /**
     * Determine if the current storage path contains a .zip folder
     *
     * @param null|string $zipName
     */
    protected function assertLogsFolderDoesNotContainZip(?string $zipName = null) : void
    {
        $now = now()->toDateString();
        $zipName = $zipName ?? "logs_archive_{$now}.zip";
        $hasZip = File::exists(storage_path("logs/{$zipName}"));
        
        $this->assertFalse($hasZip);
    }
}