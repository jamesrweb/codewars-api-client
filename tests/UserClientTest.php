<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use CodewarsKataExporter\Schemas\UserSchema;
use CodewarsKataExporter\UserClient;
use CodewarsKataExporter\UserInterface;
use Garden\Schema\RefNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class UserClientTest
 * @package CodewarsKataExporter\Tests
 */
final class UserClientTest extends TestCase
{
    private UserInterface $client;

    public function setUp(): void
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions(
            $_ENV["CODEWARS_VALID_USERNAME"],
            $_ENV["CODEWARS_DUMMY_API_KEY"]
        );
        $this->client = new UserClient($http_client, $client_options);
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testUserOverview(): void
    {
        $response = $this->client->user();
        $schema = new UserSchema();
        $this->assertEquals(true, $schema->validate($response));
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testCompletedChallenges(): void
    {
        $response = $this->client->completed();
        $schema = new CompletedChallengesSchema();
        $this->assertEquals(true, $schema->validate($response));
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testAuthoredChallenges(): void
    {
        $response = $this->client->authored();
        $schema = new AuthoredChallengesSchema();
        $this->assertEquals(true, $schema->validate($response));
    }
}