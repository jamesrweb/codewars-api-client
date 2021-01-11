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
        $this->client_options = new ClientOptions($_ENV["CODEWARS_VALID_USERNAME"], $_ENV["CODEWARS_DUMMY_API_KEY"]);
    }

    public function testHeadersGetter(): void
    {
        $this->assertEquals(
            ["headers" => ["Authorization" => $_ENV["CODEWARS_DUMMY_API_KEY"]]],
            $this->client_options->headers()
        );
    }

    public function testUsernameGetter(): void
    {
        $this->assertEquals($_ENV["CODEWARS_VALID_USERNAME"], $this->client_options->username());
    }
}