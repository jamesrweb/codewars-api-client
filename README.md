# Codewars Kata Exporter

[![Test coverage](https://img.shields.io/badge/test%20coverage-100%25-brightgreen.svg)](https://github.com/jamesrweb/codewars-kata-exporter)
[![GitHub license](https://img.shields.io/github/license/jamesrweb/codewars-kata-exporter.svg)](https://github.com/jamesrweb/codewars-kata-exporter/blob/master/LICENSE)
[![GitHub contributors](https://img.shields.io/github/contributors/jamesrweb/codewars-kata-exporter.svg)](https://GitHub.com/jamesrweb/codewars-kata-exporter/graphs/contributors/)
[![GitHub issues](https://img.shields.io/github/issues/jamesrweb/codewars-kata-exporter.svg)](https://GitHub.com/jamesrweb/codewars-kata-exporter/issues/)
[![GitHub pull requests](https://img.shields.io/github/issues-pr/jamesrweb/codewars-kata-exporter.svg)](https://GitHub.com/jamesrweb/codewars-kata-exporter/pulls/)

A library built to interact with the Codewars API and platform.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the library using the following command.

```bash
composer require jamesrweb/codewars-kata-exporter
```

## Basic Usage

Once the package has been installed, we can create the required clients like.

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use CodewarsKataExporter\UserClient;
use CodewarsKataExporter\ChallengeClient;
use CodewarsKataExporter\ClientOptions;
use Symfony\Component\HttpClient\HttpClient;

$http_client = HttpClient::create();
$client_options = new ClientOptions("your-username", "your-api-key");
$user_client = new UserClient($http_client, $client_options);
$challenge_client = new ChallengeClient($http_client, $client_options);
```

## The `UserClient`

A `UserClient` instance allows us to get information regarding a user such as their completed challenges, authored challenges and metadata such as their username, ranks, etc.

### Methods

#### Get information about the user

To get information regarding the user, you can run:

```php
$user_client->user();
```

#### Get challenges created by the user

To get a list of challenges the user created, you can run:
```php
$user_client->authored();
```

#### Get challenges completed by the user

To get a list of challenges the user completed, you can run:

```php
$user_client->completed();
```

## The `ChallengeClient`

A `ChallengeClient` instance allows us to get information regarding challenges such as challenge descriptions, difficulties, available languages, etc.

### Methods

#### Get information about a specific challenge

To get an overview regarding a specific challenge, you can run:

```php
$challenge_client->challenge(string $challenge_id);
```

#### Get information about multiple challenges

To get an overview of multiple challenges at once, you can run:

```php
$challenge_client->challenges(array $challenges);
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)