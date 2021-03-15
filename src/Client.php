<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ClientInterface;
use CodewarsKataExporter\Interfaces\ClientOptionsInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface as Psr18ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpClient\Psr18Client;

final class Client implements ClientInterface
{
    private Psr18ClientInterface $psr18Client;
    private RequestFactoryInterface $psr17Factory;
    private ClientOptionsInterface $client_options;
    private string $base_uri = 'https://www.codewars.com/api/v1';

    public function __construct(ClientOptionsInterface $options)
    {
        $this->client_options = $options;
        $this->psr18Client = new Psr18Client();
        $this->psr17Factory = new Psr17Factory();
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
        $query = http_build_query(['page' => $page - 1]);
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/completed?{$query}";
        $response = $this->request('GET', $uri);
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
        return array_reduce($challenges, function (array $accumulator, array $current): array {
            $id = $current['id'];
            $uri = "{$this->base_uri}/code-challenges/{$id}";
            $response = $this->request('GET', $uri);
            $accumulator[] = $this->parse($response);

            return $accumulator;
        }, []);
    }

    private function request(string $method, string $uri): ResponseInterface
    {
        $headers = $this->client_options->headers();
        $request = array_reduce(
            array_keys($headers),
            function (RequestInterface $accumulator, string $current) use ($headers): RequestInterface {
                return $accumulator->withHeader($current, $headers[$current]);
            },
            $this->psr17Factory->createRequest($method, $uri)
        );

        return $this->psr18Client->sendRequest($request);
    }

    private function parse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
