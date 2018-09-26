<?php

namespace Ludo237\LogsManager\Tests;

use Ludo237\LogsManager\LogsManagerServiceProvider;
use Orchestra\Testbench\TestCase as OTestCase;

/**
 * TestCase
 * @package Ludo237\LogsManager\Tests
 */
abstract class TestCase extends OTestCase
{
    protected function getPackageProviders($app)
    {
        return [LogsManagerServiceProvider::class];
    }
}
