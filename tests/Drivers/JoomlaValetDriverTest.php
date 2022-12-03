<?php

use Valet\Drivers\JoomlaValetDriver;

class JoomlaValetDriverTest extends BaseDriverTestCase
{
    public function test_it_serves_joomla_projects()
    {
        $driver = new JoomlaValetDriver();

        $this->assertTrue($driver->serves($this->projectDir('joomla'), 'my-site', '/'));
    }

    public function test_it_doesnt_serve_non_joomla_projects_with_public_directory()
    {
        $driver = new JoomlaValetDriver();

        $this->assertFalse($driver->serves($this->projectDir('public-with-index-non-laravel'), 'my-site', '/'));
    }

    public function test_it_gets_front_controller()
    {
        $driver = new JoomlaValetDriver();

        $_SERVER['HTTP_HOST'] = 'this is set in Valet requests but not phpunit';

        $projectPath = $this->projectDir('joomla');
        $this->assertEquals($projectPath.'/index.php', $driver->frontControllerPath($projectPath, 'my-site', '/'));
    }
}
