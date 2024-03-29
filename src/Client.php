<?php

declare(strict_types=1);

namespace CodewarsApiClient;

use CodewarsApiClient\Interfaces\ClientInterface as CodewarsApiClientInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use function Safe\json_decode;
use Symfony\Component\HttpClient\Psr18Client;

final class Client implements CodewarsApiClientInterface
{
    private string $api_key;
    private string $base_uri = 'https://www.codewars.com/api/v1';
    private ClientInterface $psr18Client;
    private RequestFactoryInterface $psr17Factory;

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
        $this->psr18Client = new Psr18Client();
        $this->psr17Factory = new Psr17Factory();
    }

    /**
     * {@inheritdoc}
     */
    public function user(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}";

        return $this->request('GET', $uri, []);
    }

    /**
     * {@inheritdoc}
     */
    public function authored(string $username): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/authored";
        $data = $this->request('GET', $uri, []);

        return $data['data'];
    }

    /**
     * {@inheritdoc}
     */
    public function completed(string $username): array
    {
        return $this->completedPaginationHelper($username, 1, []);
    }

    /**
     * {@inheritdoc}
     */
    public function challenge(string $id): array
    {
        $uri = "{$this->base_uri}/code-challenges/{$id}";

        return $this->request('GET', $uri, []);
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
    private function completedPaginationHelper(string $username, int $page, array $output): array
    {
        $uri = "{$this->base_uri}/users/{$username}/code-challenges/completed";
        $data = $this->request('GET', $uri, ['page' => $page - 1]);
        $output = array_merge($output, $data['data']);

        if ($page >= $data['totalPages']) {
            return $output;
        }

        return $this->completedPaginationHelper($username, $page + 1, $output);
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
    private function request(string $method, string $uri, array $query_params): array
    {
        $query_string = http_build_query(data: $query_params, encoding_type: PHP_QUERY_RFC3986);
        $request_uri = "{$uri}?{$query_string}";
        $request = $this->psr17Factory->createRequest($method, $request_uri);

        foreach ($this->headers() as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        $response = $this->psr18Client->sendRequest($request);

        return $this->parseJSONFromResponse($response);
    }

    /**
     * Generate the headers for each request made by the client.
     *
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [
            'Authorization' => $this->api_key,
            'Accept' => 'application/json',
        ];
    }

    /**
     * Parse a given response into JSON format.
     *
     * @return array<string, mixed>
     */
    private function parseJSONFromResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() === 404) {
            return [];
        }

        $response_json = json_decode($response->getBody()->getContents(), true);

        if (key_exists('success', $response_json) && $response_json['success'] === false) {
            return [];
        }

        return $response_json;
    }
}
