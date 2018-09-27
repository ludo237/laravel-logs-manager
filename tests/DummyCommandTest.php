<?php

namespace Ludo237\LogsManager\Tests;

/**
 * Class DummyCommandTest
 * @package Ludo237\LogsManager\Tests
 */
final class DummyCommandTest extends TestCase
{
    protected function tearDown()
    {
        $this->clearLogsFolder();
        
        parent::tearDown();
    }
    
    /** @test */
    public function it_creates_a_new_dummy_log()
    {
        $this->artisan("log:dummy")
            ->expectsOutput("1 dummy logs file have been created")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(1);
    }
    
    /** @test */
    public function it_creates_as_many_dummy_logs_as_the_user_wants()
    {
        $this->artisan("log:dummy", ["--quantity" => 10])
            ->expectsOutput("10 dummy logs file have been created")
            ->assertExitCode(0);
        
        $this->assertLogsFolderFilesCount(10);
    }
}