<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

/**
 * Class ClientOptions
 * @package CodewarsKataExporter
 */
final class ClientOptions implements ClientOptionsInterface
{
    private string $username;
    private string $api_key;

    /**
     * ClientOptions constructor
     *
     * @param string $username
     * @param string $api_key
     */
    public function __construct(string $username, string $api_key)
    {
        $this->username = $username;
        $this->api_key = $api_key;
    }

    /**
     * Get the username
     *
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * Get the headers for each API request of the Client
     *
     * @return array
     */
    public function headers(): array
    {
        return ["headers" => ["Authorization" => $this->api_key]];
    }
}