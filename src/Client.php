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
 * @package CodewarsKataExporter
 */
final class Client implements UserInterface, ChallengeInterface
{
    private HttpClientInterface $client;
    private string $base_url = "https://www.codewars.com/api/v1";
    private string $challenge_url;
    private string $user_url;

    /**
     * Client constructor
     *
     * @param HttpClientInterface $client
     * @param ClientOptionsInterface $options
     */
    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->user_url = $this->base_url . "/users/" . $options->getUsername();
        $this->challenge_url = $this->base_url . "/code-challenges";
        $this->client = ScopingHttpClient::forBaseUri($client, $this->user_url, $options->buildRequestOptions());
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
    public function userOverview(): array
    {
        $response = $this->client->request("GET", $this->user_url);
        return $response->toArray();
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
    private function completedChallengesHelper(int $page, array $output): array
    {
        $response = $this->client->request("GET", $this->user_url . "/code-challenges/completed?page=" . $page - 1);
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

            return $this->completedChallengesHelper($page + 1, $output);
        }

        return $output;
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
    public function completedChallenges(): array
    {
        return $this->completedChallengesHelper(1, []);
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
    public function authoredChallenges(): array
    {
        $response = $this->client->request("GET", "$this->user_url/code-challenges/authored");
        return $response->toArray();
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
        $response = $this->client->request("GET", "$this->challenge_url/$id");
        return $response->toArray();
    }
}