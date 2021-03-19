<?php

declare(strict_types=1);

namespace CodewarsApiClient;

use CodewarsApiClient\Interfaces\ClientInterface as CodewarsClientInterface;
use CodewarsApiClient\Interfaces\ClientOptionsInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
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

    public function user(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}";
        $response = $this->request('GET', $uri);

        return $this->parse($response);
    }

    public function authored(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/authored";
        $response = $this->request('GET', $uri);
        $body = $this->parse($response);

        return $body['data'];
    }

    public function completed(string $username): array
    {
        return $this->completedPaginationHelper($username);
    }

    private function completedPaginationHelper(string $username, int $page = 1, array $output = []): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/completed";
        $response = $this->request('GET', $uri, ['page' => $page - 1]);
        $body = $this->parse($response);
        $output = array_merge($output, $body['data']);

        if ($page < $body['totalPages']) {
            return $this->completedPaginationHelper($username, ++$page, $output);
        }

        return $output;
    }

    public function challenge(string $id): array
    {
        $uri = "{$this->base_uri}/code-challenges/{$id}";
        $response = $this->request('GET', $uri);

        return $this->parse($response);
    }

    public function challenges(array $challenges): array
    {
        return array_map(
            fn (string $id) => $this->challenge($id),
            $challenges
        );
    }

    private function request(string $method, string $uri, array $query_params = []): ResponseInterface
    {
        $query_string = http_build_query($query_params, '', '&', PHP_QUERY_RFC3986);
        $request_uri = "{$uri}?{$query_string}";
        $headers = $this->client_options->headers();
        $request = array_reduce(
            array_keys($headers),
            fn (RequestInterface $accumulator, string $current) => $accumulator->withHeader(
                $current,
                $headers[$current]
            ),
            $this->psr17Factory->createRequest($method, $request_uri)
        );

        return $this->psr18Client->sendRequest($request);
    }

    private function parse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
