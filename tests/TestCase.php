<?php

namespace PaulhenriL\LaravelDynamicAttributes\Tests;

use PaulhenriL\LaravelDynamicAttributes\Tests\Concerns\ManagesDatabase;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    use ManagesDatabase;

    /**
     * Prepare the DB and load a fresh schema for your test suite.
     */
    protected function setUp(): void
    {
        $this->prepareDbIfNecessary();
        $this->freshSchema();
    }
}
