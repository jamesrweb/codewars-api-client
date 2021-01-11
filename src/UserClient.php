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
 * Class UserClient
 * @package CodewarsKataExporter
 */
final class UserClient implements UserInterface
{
    private HttpClientInterface $client;
    private string $base_url = "https://www.codewars.com/api/v1";

    /**
     * Client constructor
     *
     * @param HttpClientInterface $client
     * @param ClientOptionsInterface $options
     */
    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->base_url = $this->base_url . "/users/" . $options->username();
        $this->client = ScopingHttpClient::forBaseUri($client, $this->base_url, $options->headers());
    }

    /**
     * Get an overview of the user
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function user(): array
    {
        $response = $this->client->request("GET", $this->base_url);
        return $response->toArray();
    }

    /**
     * Get the completed challenges of the user
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function completed(): array
    {
        return $this->completedPaginationHelper(1, []);
    }

    /**
     * A recursive helper to get all completed challenge solutions accounting for pagination
     *
     * @param int $page
     * @param array $output
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function completedPaginationHelper(int $page, array $output): array
    {
        $response = $this->client->request("GET", $this->base_url . "/code-challenges/completed?page=" . $page - 1);
        $response_array = $response->toArray();

        if (count($output) === 0) $output = array_merge($output, $response_array);

        if ($page <= $response_array["totalPages"]) {
            $a = array_map("serialize", $output["data"]);
            $b = array_map("serialize", $response_array["data"]);
            $differences = array_diff($a, $b);

            if (count($differences) > 0) {
                foreach ($response_array["data"] as $item) {
                    $output["data"][] = $item;
                }
            }

            return $this->completedPaginationHelper($page + 1, $output);
        }

        return $output;
    }

    /**
     * Get the challenges that the user authored
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function authored(): array
    {
        $response = $this->client->request("GET", "$this->base_url/code-challenges/authored");
        return $response->toArray();
    }
}