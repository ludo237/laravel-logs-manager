<?php

namespace Ludo237\LogsManager\Tests;

/**
 * TestCase
 * @package Ludo237\LogsManager\Tests
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }
}
