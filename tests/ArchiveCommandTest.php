<?php

namespace Ludo237\LogsManager\Tests;

use Ludo237\LogsManager\Exceptions\LogsFolderEmptyException;

/**
 * Class ArchiveCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class ArchiveCommandTest extends TestCase
{
    /** @test */
    public function it_archives_the_logs()
    {
        $this->populateLogsFolder();
        $now = now()->toDateString();
        
        $this->artisan("log:archive")
            ->expectsOutput("logs_archive_{$now}.zip is filling...")
            ->expectsOutput("Adding laravel_dummy_log_0.log to logs_archive_{$now}.zip")
            ->expectsOutput("Adding laravel_dummy_log_4.log to logs_archive_{$now}.zip")
            ->expectsOutput("logs_archive_{$now}.zip created!")
            ->assertExitCode(0);
        
        $this->assertLogsFolderContainsZip();
    }
    
    /** @test */
    public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->expectException(LogsFolderEmptyException::class);
        
        $this->artisan("log:archive")
            ->assertExitCode(0);
        
        $this->assertLogsFolderDoesNotContainZip();
    }
    
    /** @test */
    public function if_an_archive_with_the_same_name_is_already_present_it_quits()
    {
        $this->populateLogsFolder();
        $now = now()->toDateString();
        $path = storage_path("logs");
        
        $this->artisan("log:archive")->run();
        
        $this->artisan("log:archive")
            ->expectsOutput("An archive called logs_archive_{$now}.zip already exists in {$path}");
    }
    
    /** @test */
    public function it_accepts_a_name_for_customization()
    {
        $this->populateLogsFolder();
    
        $this->artisan("log:archive", ["name" => "foobar"])
            ->expectsOutput("foobar.zip is filling...")
            ->expectsOutput("Adding laravel_dummy_log_0.log to foobar.zip")
            ->expectsOutput("Adding laravel_dummy_log_4.log to foobar.zip")
            ->expectsOutput("foobar.zip created!")
            ->assertExitCode(0);
    
        $this->assertLogsFolderContainsZip("foobar.zip");
    }

    /** @test */
    public function it_can_remove_an_archive()
    {
        $this->populateLogsFolder();
        $now = now()->toDateString();
        $path = storage_path("logs");
    
        $this->artisan("log:archive", ["--remove" => true])
            ->expectsOutput("Archive logs_archive_{$now}.zip removed from {$path}");
        
        $this->assertLogsFolderDoesNotContainZip();
    }
}