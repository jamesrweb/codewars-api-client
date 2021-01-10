<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\ClientOptionsInterface;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use CodewarsKataExporter\Schemas\UserSchema;
use Garden\Schema\RefNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ClientTest
 * @package App\Tests
 */
final class ClientTest extends TestCase
{
    private HttpClientInterface $http_client;
    private ClientOptionsInterface $client_options;

    public function setUp(): void
    {
        $this->http_client = HttpClient::create();
        $this->client_options = new ClientOptions($_ENV["CODEWARS_VALID_USERNAME"]);
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testUserOverviewHappyPath(): void
    {
        $client = new Client($this->http_client, $this->client_options);

        $response = $client->userOverview();

        $user_schema = new UserSchema($response);
        $this->assertEquals(true, $user_schema->validate());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testUserOverviewThrowsWithInvalidUsernameOption(): void
    {
        $this->client_options->setUsername($_ENV["CODEWARS_INVALID_USERNAME"]);
        $client = new Client($this->http_client, $this->client_options);

        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $client->userOverview();
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testCompletedChallengesHappyPath(): void
    {
        $client = new Client($this->http_client, $this->client_options);

        $response = $client->completedChallenges();

        $completed_challenges_schema = new CompletedChallengesSchema($response);
        $this->assertEquals(true, $completed_challenges_schema->validate());
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testAuthoredChallengesHappyPath(): void
    {
        $client = new Client($this->http_client, $this->client_options);

        $response = $client->authoredChallenges();

        $completed_challenges_schema = new AuthoredChallengesSchema($response);
        $this->assertEquals(true, $completed_challenges_schema->validate());
    }

    /**
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testChallengeOverviewHappyPath(): void
    {
        $client = new Client($this->http_client, $this->client_options);

        $response = $client->challenge($_ENV["CODEWARS_VALID_CHALLENGE_ID"]);

        $completed_challenges_schema = new ChallengeSchema($response);
        $this->assertEquals(true, $completed_challenges_schema->validate());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testChallengeOverviewThrowsForAnInvalidId(): void
    {
        $client = new Client($this->http_client, $this->client_options);

        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $client->challenge($_ENV["CODEWARS_INVALID_CHALLENGE_ID"]);
    }
}