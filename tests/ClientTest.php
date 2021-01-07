<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\Schemas;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use ValueError;

/**
 * Class ClientTest
 * @package App\Tests
 */
final class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $http_client = HttpClient::create();
        $this->client = new Client($http_client, "api_key");
    }

    public function testUsernameIsInitiallyEmpty()
    {
        $this->assertEquals("", $this->client->getUsername());
    }

    public function testUsernameIsUpdatedWhenProvided()
    {
        $this->client->setUsername("jamesrweb");
        $this->assertEquals("jamesrweb", $this->client->getUsername());
    }

    public function testGetUserThrowsWhenNoUsernameSet()
    {
        $this->expectException(ValueError::class);
        $this->client->getUser();
    }

    public function testGetUserThrowsWhenInvalidUserProvided()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);
        $this->client->setUsername("user");
        $this->client->getUser();
    }

    public function testGetUserReturnsCorrectResponseWithValidUsernameProvided()
    {
        $this->client->setUsername("jamesrweb");
        $response = $this->client->getUser();
        $user_schema = new Schemas\UserSchema($response);
        $this->assertEquals(true, $user_schema->validate());
    }
}