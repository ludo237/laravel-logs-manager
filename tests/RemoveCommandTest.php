<?php

namespace Ludo237\LogsManager\Tests;

use Ludo237\LogsManager\Exceptions\LogsFolderEmptyException;

/**
 * Class RemoveCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class RemoveCommandTest extends TestCase
{
    /** @test */
    public function it_removes_a_selected_log_file()
    {
        $this->populateLogsFolder();
        
        $this->artisan("log:remove")
            ->expectsQuestion("Which log file would you like to remove?", "laravel_dummy_log_0.log")
            ->expectsOutput("laravel_dummy_log_0.log removed")
            ->expectsOutput("Remove complete")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(4);
    }
    
    /** @test */
    public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->expectException(LogsFolderEmptyException::class);
        
        $this->artisan("log:remove")
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_accepts_an_all_parameter()
    {
        $this->populateLogsFolder();
        
        $this->artisan("log:remove", ["--all" => true])
            ->expectsOutput("laravel_dummy_log_0.log removed")
            ->expectsOutput("laravel_dummy_log_1.log removed")
            ->expectsOutput("laravel_dummy_log_2.log removed")
            ->expectsOutput("laravel_dummy_log_3.log removed")
            ->expectsOutput("laravel_dummy_log_4.log removed")
            ->expectsOutput("Remove complete")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(0);
    }
}