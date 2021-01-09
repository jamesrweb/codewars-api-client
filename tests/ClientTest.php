<?php

declare(strict_types=1);

namespace CodewarsKataExporter\Tests;

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use CodewarsKataExporter\Schemas;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class ClientTest
 * @package App\Tests
 */
final class ClientTest extends TestCase
{
    public function testUserOverviewHappyPath()
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions("jamesrweb");
        $client = new Client($http_client, $client_options);

        $response = $client->userOverview();
        $user_schema = new Schemas\UserSchema($response);

        $this->assertEquals(true, $user_schema->validate());
    }

    public function testUserOverviewThrowsWithInvalidUsernameOption()
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions(base64_encode("invalid"));
        $client = new Client($http_client, $client_options);

        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $client->userOverview();
    }

    public function testCompletedChallengesHappyPath()
    {
        $http_client = HttpClient::create();
        $client_options = new ClientOptions("jamesrweb");
        $client = new Client($http_client, $client_options);

        $response = $client->completedChallenges();
        $completed_challenges_schema = new Schemas\CompletedChallengesSchema($response);

        $this->assertEquals(true, $completed_challenges_schema->validate());
    }
}