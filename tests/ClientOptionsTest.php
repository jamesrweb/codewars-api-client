<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ClientOptions;
use PHPUnit\Framework\TestCase;

final class ClientOptionsTest extends TestCase
{
    private ClientOptions $options;

    protected function setUp(): void
    {
        $this->options = new ClientOptions($_ENV['CODEWARS_DUMMY_API_KEY']);
    }

    public function testHeaders(): void
    {
        $this->assertEquals(
            ['headers' => ['Authorization' => $_ENV['CODEWARS_DUMMY_API_KEY']]],
            $this->options->headers()
        );
    }
}
