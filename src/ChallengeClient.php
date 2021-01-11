<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

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
final class ChallengeClient implements ChallengeInterface
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
}