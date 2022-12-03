<?php

use Valet\Drivers\BedrockValetDriver;

class BedrockValetDriverTest extends BaseDriverTestCase
{
    public function test_it_serves_bedrock_projects()
    {
        $driver = new BedrockValetDriver();

        $this->assertTrue($driver->serves($this->projectDir('bedrock'), 'my-site', '/'));
    }

    public function test_it_doesnt_serve_non_bedrock_projects()
    {
        $driver = new BedrockValetDriver();

        $this->assertFalse($driver->serves($this->projectDir('public-with-index-non-laravel'), 'my-site', '/'));
    }

    public function test_it_gets_front_controller()
    {
        $driver = new BedrockValetDriver();

        $_SERVER['HTTP_HOST'] = 'this is set in Valet requests but not phpunit';

        $projectPath = $this->projectDir('bedrock');
        $this->assertEquals($projectPath.'/web/index.php', $driver->frontControllerPath($projectPath, 'my-site', '/'));
    }
}
