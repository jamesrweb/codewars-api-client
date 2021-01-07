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
use ValueError;

/**
 * Class Client
 * @package App
 */
class Client
{
    private HttpClientInterface $client;
    private string $username = "";
    private string $base_url = "https://www.codewars.com/api/v1/users";

    /**
     * Client constructor
     *
     * @param HttpClientInterface $client
     * @param string $api_key
     */
    public function __construct(HttpClientInterface $client, string $api_key)
    {
        $client_options = ["headers" => ["Authorization" => $api_key]];
        $this->client = ScopingHttpClient::forBaseUri($client, $this->base_url, $client_options);
    }

    /**
     * Get the currently set username used in requests
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the username of the user you want to use for requests
     *
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Get the overview of the currently set user
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getUser(): array
    {
        if (empty($this->username)) throw new ValueError("Username must be set");
        $response = $this->client->request("GET", $this->base_url . "/$this->username");
        return $response->toArray();
    }
}