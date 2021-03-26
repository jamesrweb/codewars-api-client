<?php

declare(strict_types=1);

namespace Tests;

use CodewarsApiClient\Client;
use CodewarsApiClient\ClientOptions;
use CodewarsApiClient\Interfaces\ClientInterface;
use PHPUnit\Framework\TestCase;
use Tests\Schemas\AuthoredChallengesSchema;
use Tests\Schemas\ChallengeSchema;
use Tests\Schemas\CompletedChallengesSchema;
use Tests\Schemas\UserSchema;

/**
 * @internal
 */
final class ClientTest extends TestCase
{
    private ClientInterface $client;

    protected function setUp(): void
    {
        $this->client = new Client($_ENV['CODEWARS_DUMMY_API_KEY']);
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
        $response = $this->client->challenges([$_ENV['CODEWARS_VALID_CHALLENGE_ID']]);
        $candidate = array_shift($response);
        $this->assertEquals(true, (new ChallengeSchema())->validate($candidate));
    }

    public function testClientReturnsEmptyArrayWhen404(): void
    {
        $response = $this->client->user($_ENV['CODEWARS_INVALID_USERNAME']);
        $this->assertEquals([], $response);
    }
}
