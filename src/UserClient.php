<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ClientOptionsInterface;
use CodewarsKataExporter\Interfaces\UserClientInterface;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class UserClient implements UserClientInterface
{
    private HttpClientInterface $client;
    private string $base_url = 'https://www.codewars.com/api/v1/users';

    public function __construct(HttpClientInterface $client, ClientOptionsInterface $options)
    {
        $this->client = ScopingHttpClient::forBaseUri(
            $client,
            $this->base_url,
            $options->headers()
        );
    }

    public function user(string $username): array
    {
        $url = "{$this->base_url}/{$username}";

        return $this->client->request('GET', $url)->toArray();
    }

    public function authored(string $username): array
    {
        $url = "{$this->base_url}/{$username}/code-challenges/authored";
        $response = $this->client->request('GET', $url)->toArray();

        return $response['data'];
    }

    public function completed(string $username): array
    {
        return $this->completedPaginationHelper($username);
    }

    private function completedPaginationHelper(string $username, int $page = 1, array $output = []): array
    {
        $query = http_build_query(['page' => $page - 1]);
        $url = "{$this->base_url}/{$username}/code-challenges/completed?{$query}";
        $response = $this->client->request('GET', $url)->toArray();
        $output = array_merge($output, $response['data']);

        if ($page < $response['totalPages']) {
            return $this->completedPaginationHelper($username, ++$page, $output);
        }

        return $output;
    }
}
