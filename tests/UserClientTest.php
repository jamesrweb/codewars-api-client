<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Interfaces\UserClientInterface;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use CodewarsKataExporter\Schemas\UserSchema;
use CodewarsKataExporter\UserClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

final class UserClientTest extends TestCase
{
    private UserClientInterface $client;

    protected function setUp(): void
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions($_ENV['CODEWARS_DUMMY_API_KEY']);
        $this->client = new UserClient($http_client, $client_options);
    }

    public function testUser(): void
    {
        $response = $this->client->user($_ENV['CODEWARS_VALID_USERNAME']);
        $this->assertEquals(true, (new UserSchema())->validate($response));
    }

    public function testCompletedChallenges(): void
    {
        $response = $this->client->completed($_ENV['CODEWARS_VALID_USERNAME']);
        $this->assertEquals(true, (new CompletedChallengesSchema())->validate($response));
    }

    public function testAuthoredChallenges(): void
    {
        $response = $this->client->authored($_ENV['CODEWARS_VALID_USERNAME']);
        $this->assertEquals(true, (new AuthoredChallengesSchema())->validate($response));
    }
}
