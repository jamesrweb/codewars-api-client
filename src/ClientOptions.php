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
    private ?string $api_key;

    /**
     * ClientOptions constructor
     *
     * @param string $username
     * @param string|null $api_key
     */
    public function __construct(string $username, ?string $api_key = null)
    {
        $this->username = $username;
        $this->api_key = $api_key;
    }

    /**
     * Get the currently set username option
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the username option
     *
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Get the currently set api key option
     *
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->api_key;
    }

    /**
     * Set the api key option
     *
     * @param string $api_key
     */
    public function setApiKey(string $api_key): void
    {
        $this->api_key = $api_key;
    }

    /**
     * Build the options for each API request of the Client
     *
     * @return array
     */
    public function buildRequestOptions(): array
    {
        $result = [];
        if (is_null($this->api_key) === false) {
            $result["headers"] = ["Authorization" => $this->api_key];
        }
        return $result;
    }
}