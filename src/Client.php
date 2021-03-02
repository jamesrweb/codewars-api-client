<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ClientInterface;
use CodewarsKataExporter\Interfaces\ClientOptionsInterface;
use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Http\Promise\Promise;
use Psr\Http\Message\ResponseInterface;

final class Client implements ClientInterface
{
    private GuzzleAdapter $client;

    public function __construct(ClientOptionsInterface $options)
    {
        $client = new HTTPClient([
            'base_uri' => 'https://www.codewars.com/api/v1/',
            'headers' => $options->headers(),
        ]);
        $this->client = new GuzzleAdapter($client);
    }

    public function user(string $username): array
    {
        $url = "users/{$username}";
        $response = $this->request('GET', $url);

        return $this->parse($response);
    }

    public function authored(string $username): array
    {
        $url = "users/{$username}/code-challenges/authored";
        $response = $this->request('GET', $url);
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
        $response = $this->request('GET', "users/{$username}/code-challenges/completed?{$query}");
        $body = $this->parse($response);
        $output = array_merge($output, $body['data']);

        if ($page < $body['totalPages']) {
            return $this->completedPaginationHelper($username, ++$page, $output);
        }

        return $output;
    }

    public function challenge(string $id): array
    {
        $response = $this->request('GET', "code-challenges/{$id}");

        return $this->parse($response);
    }

    public function challenges(array $challenges): array
    {
        $requests = array_reduce($challenges, function (array $accumulator, array $current): array {
            $id = $current['id'];
            $accumulator[] = $this->requestAsync('GET', "code-challenges/{$id}");

            return $accumulator;
        }, []);

        return array_map(
            fn (ResponseInterface $response) => $this->parse($response),
            Utils::unwrap($requests)
        );
    }

    private function request(string $method, string $url): ResponseInterface
    {
        $request = new Request($method, $url);

        return $this->client->sendRequest($request);
    }

    private function requestAsync(string $method, string $url): Promise
    {
        $request = new Request($method, $url);

        return $this->client->sendAsyncRequest($request);
    }

    private function parse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
