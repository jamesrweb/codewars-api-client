<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ClientOptions;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package App\Tests
 */
final class ClientOptionsTest extends TestCase
{
    private ClientOptions $client_options;

    protected function setUp(): void
    {
        $this->client_options = new ClientOptions("jamesrweb");
    }

    public function testBuildRequestOptionsDefaultPath()
    {
        $this->assertEquals([], $this->client_options->buildRequestOptions());
    }

    public function testBuildRequestOptionsHeadersPath()
    {
        $this->client_options->setApiKey("test_key");
        $this->assertEquals(
            ["headers" => ["Authorization" => "test_key"]],
            $this->client_options->buildRequestOptions()
        );
    }

    public function testGetUsername()
    {
        $this->assertEquals("jamesrweb", $this->client_options->getUsername());
    }

    public function testSetUsername()
    {
        $this->client_options->setUsername("someone_else");
        $this->assertEquals("someone_else", $this->client_options->getUsername());
    }

    public function testGetApiKey()
    {
        $this->assertEquals(null, $this->client_options->getApiKey());
    }

    public function testSetApiKey()
    {
        $this->client_options->setApiKey("test_key");
        $this->assertEquals("test_key", $this->client_options->getApiKey());
    }
}