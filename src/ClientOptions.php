<?php

declare(strict_types=1);

namespace CodewarsApiClient;

use CodewarsApiClient\Interfaces\ClientOptionsInterface;

final class ClientOptions implements ClientOptionsInterface
{
    public function __construct(private string $api_key)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function headers(): array
    {
        return [
            'Authorization' => $this->api_key,
            'Accept' => 'application/json',
        ];
    }
}
