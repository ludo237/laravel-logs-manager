<?php

namespace Ludo237\LogsManager\Tests;

use Ludo237\LogsManager\Exceptions\LogsFolderEmptyException;

/**
 * Class ListCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class ListCommandTest extends TestCase
{
    /** @test */
    public function it_shows_a_table_of_logs()
    {
        $this->markTestSkipped("Cannot test table output");
        $this->populateLogsFolder(1);
        
        $this->artisan("log:list")
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_displays_a_message_if_the_log_folder_is_empty()
    {
        $this->expectException(LogsFolderEmptyException::class);
        
        $this->artisan("log:list")
            ->assertExitCode(0);
    }
}