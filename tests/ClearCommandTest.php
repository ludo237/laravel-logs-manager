<?php

namespace Ludo237\LogsManager\Tests;

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
        
        $this->artisan("logs:clear")
            ->expectsQuestion("There are 5 files, do you want to remove them?", true)
            ->expectsOutput("Removing: laravel_foobar_1.log")
            ->expectsOutput("Removing: laravel_foobar_2.log")
            ->expectsOutput("Removing: laravel_foobar_3.log")
            ->expectsOutput("Removing: laravel_foobar_4.log")
            ->expectsOutput("Removing: laravel_foobar_5.log")
            ->expectsOutput("5 files have been removed!")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(0);
    }
    
    /** @test */
    public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->artisan("logs:clear")
            ->expectsOutput("Logs folder is empty")
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_requests_a_confirmation_to_proceed()
    {
        $this->populateLogsFolder();

        $this->artisan("logs:clear")
            ->expectsQuestion("There are 5 files, do you want to remove them?", false)
            ->assertExitCode(0);
    
        $this->assertLogsFolderFilesCount(5);
    }
}