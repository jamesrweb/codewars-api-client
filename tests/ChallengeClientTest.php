<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\ChallengeClient;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Interfaces\ChallengeClientInterface;
use CodewarsKataExporter\Interfaces\SchemaInterface;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

final class ChallengeClientTest extends TestCase
{
    private ChallengeClientInterface $client;
    private SchemaInterface $schema;

    protected function setUp(): void
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions($_ENV['CODEWARS_DUMMY_API_KEY']);
        $this->client = new ChallengeClient($http_client, $client_options);
        $this->schema = new ChallengeSchema();
    }

    public function testChallenge(): void
    {
        $response = $this->client->challenge($_ENV['CODEWARS_VALID_CHALLENGE_ID']);
        $this->assertEquals(true, $this->schema->validate($response));
    }

    public function testChallenges(): void
    {
        $challenge = ['id' => $_ENV['CODEWARS_VALID_CHALLENGE_ID']];
        $response = $this->client->challenges([$challenge]);
        $this->assertEquals(true, $this->schema->validate($response[0]));
    }
}
