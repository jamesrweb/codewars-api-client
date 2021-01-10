<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ClientOptions;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientOptionsTest
 * @package CodewarsKataExporter\Tests
 */
final class ClientOptionsTest extends TestCase
{
    private ClientOptions $client_options;

    protected function setUp(): void
    {
        $this->client_options = new ClientOptions($_ENV["CODEWARS_VALID_USERNAME"]);
    }

    public function testBuildRequestOptionsDefaultPath(): void
    {
        $this->assertEquals([], $this->client_options->buildRequestOptions());
    }

    public function testBuildRequestOptionsHeadersPath(): void
    {
        $api_key = $_ENV["CODEWARS_DUMMY_API_KEY"];
        $this->client_options->setApiKey($api_key);
        $this->assertEquals(
            ["headers" => ["Authorization" => $api_key]],
            $this->client_options->buildRequestOptions()
        );
    }

    public function testGetUsername(): void
    {
        $this->assertEquals($_ENV["CODEWARS_VALID_USERNAME"], $this->client_options->getUsername());
    }

    public function testSetUsername(): void
    {
        $username = $_ENV["CODEWARS_INVALID_USERNAME"];
        $this->client_options->setUsername($username);
        $this->assertEquals($username, $this->client_options->getUsername());
    }

    public function testGetApiKey(): void
    {
        $this->assertEquals(null, $this->client_options->getApiKey());
    }

    public function testSetApiKey(): void
    {
        $api_key = $_ENV["CODEWARS_DUMMY_API_KEY"];
        $this->client_options->setApiKey($api_key);
        $this->assertEquals($api_key, $this->client_options->getApiKey());
    }
}