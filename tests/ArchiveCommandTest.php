<?php

namespace Ludo237\LogsManager\Tests;

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
            ->assertExitCode(0);
        
    }
    
    /** @test */
   public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->artisan("log:archive")
            ->expectsOutput("Logs folder is empty")
            ->assertExitCode(0);
    }
    
    public function if_an_archive_with_the_same_name_is_already_present_it_quits()
    {
    
    }
    
    public function it_accepts_a_name_for_customization()
    {
    
    }
    
    public function it_can_remove_an_archive()
    {
    
    }
}