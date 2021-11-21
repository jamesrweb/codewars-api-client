<?php

declare(strict_types=1);

namespace Tests;

use CodewarsApiClient\Client;
use CodewarsApiClient\Interfaces\ClientInterface;
use PHPUnit\Framework\TestCase;
use Tests\Schemas\AuthoredChallengesSchema;
use Tests\Schemas\ChallengeSchema;
use Tests\Schemas\CompletedChallengesSchema;
use Tests\Schemas\UserSchema;

/**
 * @internal
 *
 * @small
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
        $schema = new UserSchema();

        $response = $this->client->user($_ENV['CODEWARS_VALID_USERNAME']);

        $this->assertTrue($schema->validate($response));
    }

    public function testCompletedChallenges(): void
    {
        $schema = new CompletedChallengesSchema();

        $response = $this->client->completed($_ENV['CODEWARS_VALID_USERNAME']);

        $this->assertTrue($schema->validate($response));
    }

    public function testAuthoredChallenges(): void
    {
        $schema = new AuthoredChallengesSchema();

        $response = $this->client->authored($_ENV['CODEWARS_VALID_USERNAME']);

        $this->assertTrue($schema->validate($response));
    }

    public function testChallenge(): void
    {
        $schema = new ChallengeSchema();

        $response = $this->client->challenge($_ENV['CODEWARS_VALID_CHALLENGE_ID']);

        $this->assertTrue($schema->validate($response));
    }

    public function testChallenges(): void
    {
        $schema = new ChallengeSchema();

        $response = $this->client->challenges([$_ENV['CODEWARS_VALID_CHALLENGE_ID']]);

        $this->assertTrue($schema->validate(array_shift($response)));
    }

    public function testClientReturnsEmptyArrayWhen404(): void
    {
        $response = $this->client->user($_ENV['CODEWARS_INVALID_USERNAME']);

        $this->assertSame([], $response);
    }

    public function testClientReturnsEmptyArrayWhenResponseIsUnsuccessful(): void
    {
        $response = $this->client->user('');

        $this->assertSame([], $response);
    }
}
