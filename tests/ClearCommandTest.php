<?php

namespace Ludo237\LogsManager\Tests;

use Ludo237\LogsManager\Exceptions\LogsFolderEmptyException;

/**
 * Class ClearCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class ClearCommandTest extends TestCase
{
    /** @test */
    public function it_clears_the_log_folder()
    {
        $this->populateLogsFolder();
        
        $this->artisan("log:clear")
            ->expectsQuestion("There are 5 files, do you want to remove them?", true)
            ->expectsOutput("Removing: laravel_dummy_log_0.log")
            ->expectsOutput("Removing: laravel_dummy_log_1.log")
            ->expectsOutput("Removing: laravel_dummy_log_2.log")
            ->expectsOutput("Removing: laravel_dummy_log_3.log")
            ->expectsOutput("Removing: laravel_dummy_log_4.log")
            ->expectsOutput("5 files have been removed!")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(0);
    }
    
    /** @test */
    public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->expectException(LogsFolderEmptyException::class);
        
        $this->artisan("log:clear")
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_requests_a_confirmation_to_proceed()
    {
        $this->populateLogsFolder();

        $this->artisan("log:clear")
            ->expectsQuestion("There are 5 files, do you want to remove them?", false)
            ->assertExitCode(0);
    
        $this->assertLogsFolderFilesCount(5);
    }
    
    /** @test */
    public function it_accepts_a_force_parameter()
    {
        $this->populateLogsFolder();
        
        $this->artisan("log:clear", ["--force" => true])
            ->expectsOutput("Removing: laravel_dummy_log_0.log")
            ->expectsOutput("Removing: laravel_dummy_log_1.log")
            ->expectsOutput("Removing: laravel_dummy_log_2.log")
            ->expectsOutput("Removing: laravel_dummy_log_3.log")
            ->expectsOutput("Removing: laravel_dummy_log_4.log")
            ->expectsOutput("5 files have been removed!")
            ->assertExitCode(0);
    
        $this->assertLogsFolderFilesCount(0);
    }
}