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
 * Class Client
 * @package App
 */
final class Client
{
    private HttpClientInterface $client;
    private string $base_url = "https://www.codewars.com/api/v1/users";

    /**
     * Client constructor
     *
     * @param HttpClientInterface $client
     * @param ClientOptionsInterface $options
     */
    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->base_url = $this->base_url . "/" . $options->getUsername();
        $this->client = ScopingHttpClient::forBaseUri($client, $this->base_url, $options->buildRequestOptions());
    }

    /**
     * Get an overview of a user
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function userOverview(): array
    {
        $response = $this->client->request("GET", $this->base_url);
        return $response->toArray();
    }

    /**
     * Get the completed challenges of a user
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function completedChallenges()
    {
        $response = $this->client->request("GET", "$this->base_url/code-challenges/completed");
        return $response->toArray();
    }
}