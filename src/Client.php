<?php

declare(strict_types=1);

namespace CodewarsApiClient;

use CodewarsApiClient\Interfaces\ClientInterface as CodewarsClientInterface;
use CodewarsApiClient\Interfaces\ClientOptionsInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpClient\Psr18Client;

final class Client implements CodewarsClientInterface
{
    private ClientInterface $psr18Client;
    private RequestFactoryInterface $psr17Factory;
    private ClientOptionsInterface $client_options;
    private string $base_uri = 'https://www.codewars.com/api/v1';

    public function __construct(
        ClientOptionsInterface $options,
        ?ClientInterface $http_client = null,
        ?RequestFactoryInterface $http_factory = null
    ) {
        $this->client_options = $options;
        $this->psr18Client = $http_client ?? new Psr18Client();
        $this->psr17Factory = $http_factory ?? new Psr17Factory();
    }

    /**
     * {@inheritdoc}
     */
    public function user(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}";

        return $this->request('GET', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function authored(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/authored";
        $data = $this->request('GET', $uri);

        return $data['data'];
    }

    /**
     * {@inheritdoc}
     */
    public function completed(string $username): array
    {
        return $this->completedPaginationHelper($username);
    }

    /**
     * {@inheritdoc}
     */
    public function challenge(string $id): array
    {
        $uri = "{$this->base_uri}/code-challenges/{$id}";

        return $this->request('GET', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function challenges(array $challenges): array
    {
        return array_map(
            fn (string $id) => $this->challenge($id),
            $challenges
        );
    }

    /**
     * Read through pagination to collect all completed challenges for a given user.
     *
     * @param array<mixed> $output
     *
     * @return array<mixed>
     */
    private function completedPaginationHelper(string $username, int $page = 1, array $output = []): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/completed";
        $data = $this->request('GET', $uri, ['page' => $page - 1]);
        $output = array_merge($output, $data['data']);

        if ($page < $data['totalPages']) {
            return $this->completedPaginationHelper($username, ++$page, $output);
        }

        return $output;
    }

    /**
     * Send an http request and return formatted data.
     *
     * @param array<string, string | int> $query_params
     *
     * @throws ClientExceptionInterface
     *
     * @return array<string, mixed>
     */
    private function request(string $method, string $uri, array $query_params = []): array
    {
        $query_string = http_build_query(data: $query_params, encoding_type: PHP_QUERY_RFC3986);
        $request_uri = "{$uri}?{$query_string}";
        $request = $this->psr17Factory->createRequest($method, $request_uri);

        foreach ($this->client_options->headers() as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        $response = $this->psr18Client->sendRequest($request);

        return $response->getStatusCode() !== 404 ? $this->parse($response) : [];
    }

    /**
     * Parse a given response into JSON format.
     *
     * @return array<string, mixed>
     */
    private function parse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
