<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ChallengeClient;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Interfaces\ChallengeClientInterface;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use Garden\Schema\RefNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ChallengeClientTest
 * @package CodewarsKataExporter\Tests
 */
final class ChallengeClientTest extends TestCase
{
    private ChallengeClientInterface $client;

    public function setUp(): void
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions(
            $_ENV["CODEWARS_VALID_USERNAME"],
            $_ENV["CODEWARS_DUMMY_API_KEY"]
        );
        $this->client = new ChallengeClient($http_client, $client_options);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws RefNotFoundException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testChallengeOverview(): void
    {
        $response = $this->client->challenge($_ENV["CODEWARS_VALID_CHALLENGE_ID"]);
        $schema = new ChallengeSchema();
        $this->assertEquals(true, $schema->validate($response));
    }

    public function testChallenges(): void
    {
        $challenge = ["id" => $_ENV["CODEWARS_VALID_CHALLENGE_ID"]];
        $response = $this->client->challenges([$challenge]);
        $schema = new ChallengeSchema();
        $this->assertEquals(true, $schema->validate($response[0]));
    }
}