<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Interfaces\ClientInterface;
use CodewarsKataExporter\Schemas\AuthoredChallengesSchema;
use CodewarsKataExporter\Schemas\ChallengeSchema;
use CodewarsKataExporter\Schemas\CompletedChallengesSchema;
use CodewarsKataExporter\Schemas\UserSchema;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    private ClientInterface $client;

    protected function setUp(): void
    {
        $options = new ClientOptions($_ENV['CODEWARS_DUMMY_API_KEY']);
        $this->client = new Client($options);
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

    public function testChallenge(): void
    {
        $response = $this->client->challenge($_ENV['CODEWARS_VALID_CHALLENGE_ID']);
        $this->assertEquals(true, (new ChallengeSchema())->validate($response));
    }

    public function testChallenges(): void
    {
        $challenge = ['id' => $_ENV['CODEWARS_VALID_CHALLENGE_ID']];
        $response = $this->client->challenges([$challenge]);
        $candidate = array_shift($response);
        $this->assertEquals(true, (new ChallengeSchema())->validate($candidate));
    }
}