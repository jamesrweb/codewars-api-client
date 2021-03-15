<?php

declare(strict_types=1);

namespace CodewarsKataExporter;

use CodewarsKataExporter\Interfaces\ClientOptionsInterface;

final class ClientOptions implements ClientOptionsInterface
{
    public function __construct(private string $api_key)
    {
    }

    public function headers(): array
    {
        return [
            'Authorization' => $this->api_key,
            'Accept' => 'application/json',
        ];
    }
}
