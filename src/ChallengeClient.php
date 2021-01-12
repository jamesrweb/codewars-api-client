<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ChallengeClientInterface;
use CodewarsKataExporter\Interfaces\ClientOptionsInterface;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ChallengeClient
 * @package CodewarsKataExporter
 */
final class ChallengeClient implements ChallengeClientInterface
{
    private HttpClientInterface $client;
    private string $base_url = "https://www.codewars.com/api/v1/code-challenges";

    /**
     * ChallengeClient constructor
     *
     * @param HttpClientInterface $client
     * @param ClientOptionsInterface $options
     */
    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->client = ScopingHttpClient::forBaseUri($client, $this->base_url, $options->headers());
    }

    /**
     * Gets the information regarding a specific challenge by id
     *
     * @param string $id
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function challenge(string $id): array
    {
        $response = $this->client->request("GET", "$this->base_url/$id");
        return $response->toArray();
    }

    /**
     * Gets the information regarding multiple challenges
     *
     * @param array $challenges
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function challenges(array $challenges): array
    {
        $result = [];
        $responses = array_map(
            fn(array $challenge) => $this->client->request(
                "GET",
                $this->base_url . "/" . $challenge["id"]
            ),
            $challenges
        );

        foreach ($this->client->stream($responses) as $response => $chunk) {
            if ($chunk->isTimeout()) $response->cancel();
            if ($chunk->isLast()) $result[] = $response->toArray();
        }

        return $result;
    }
}