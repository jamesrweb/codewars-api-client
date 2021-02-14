<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ChallengeClientInterface;
use CodewarsKataExporter\Interfaces\ClientOptionsInterface;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ChallengeClient implements ChallengeClientInterface
{
    private HttpClientInterface $client;
    private string $base_url = 'https://www.codewars.com/api/v1/code-challenges';

    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->client = ScopingHttpClient::forBaseUri($client, $this->base_url, $options->headers());
    }

    public function challenge(string $id): array
    {
        return $this->client->request('GET', "{$this->base_url}/{$id}")->toArray();
    }

    public function challenges(array $challenges): array
    {
        $result = [];
        $responses = array_map(
            fn (array $challenge) => $this->client->request(
                'GET',
                "{$this->base_url}/{$challenge['id']}"
            ),
            $challenges
        );

        foreach ($this->client->stream($responses) as $response => $chunk) {
            if ($chunk->isLast()) {
                $result[] = $response->toArray();
            }
        }

        return $result;
    }
}
