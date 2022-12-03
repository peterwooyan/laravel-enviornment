<?php

class BaseDriverTestCase extends Yoast\PHPUnitPolyfills\TestCases\TestCase
{
    public function projects(): array
    {
        return Filesystem::scanDir(__DIR__.'/projects');
    }

    public function projectDir(string $name): string
    {
        return __DIR__.'/projects/'.$name;
    }
}
