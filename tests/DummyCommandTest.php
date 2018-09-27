<?php

namespace Ludo237\LogsManager\Tests;

/**
 * Class DummyCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class DummyCommandTest extends TestCase
{
    /** @test */
    public function it_creates_a_new_dummy_log()
    {
        $this->artisan("log:dummy")
            ->expectsOutput("1 dummy files have been created")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(1);
    }
    
    /** @test */
    public function it_creates_as_many_dummy_logs_as_the_user_wants()
    {
        $this->artisan("log:dummy", ["--quantity" => 10])
            ->expectsOutput("10 dummy files have been created")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(10);
    }
    
    /** @test */
    public function it_accepts_a_file_name_as_argument()
    {
        $this->artisan("log:dummy", ["name" => "foo_bar"])
            ->expectsOutput("1 dummy files named foo_bar have been created")
            ->assertExitCode(0);
    
        $this->assertLogsFolderFilesCount(1);
    }
}