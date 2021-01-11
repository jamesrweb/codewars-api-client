<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use CodewarsKataExporter\Schemas\UserSchema;
use Garden\Schema\RefNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ClientTest
 * @package App\Tests
 */
final class ClientTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions(
            $_ENV["CODEWARS_VALID_USERNAME"],
            $_ENV["CODEWARS_DUMMY_API_KEY"]
        );
        $this->client = new Client($http_client, $client_options);
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
        $response = $this->client->userOverview();
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
        $response = $this->client->completedChallenges();
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
        $response = $this->client->authoredChallenges();
        $schema = new AuthoredChallengesSchema();
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
    public function testChallengeOverview(): void
    {
        $response = $this->client->challenge(
            $_ENV["CODEWARS_VALID_CHALLENGE_ID"]
        );
        $schema = new ChallengeSchema();
        $this->assertEquals(true, $schema->validate($response));
    }
}