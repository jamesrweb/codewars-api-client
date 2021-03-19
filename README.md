# Codewars Kata Exporter

[![Test coverage](https://img.shields.io/badge/test%20coverage-100%25-brightgreen.svg)](https://github.com/jamesrweb/codewars-api-client)
[![GitHub license](https://img.shields.io/github/license/jamesrweb/codewars-api-client.svg)](https://github.com/jamesrweb/codewars-api-client/blob/master/LICENSE)
[![GitHub contributors](https://img.shields.io/github/contributors/jamesrweb/codewars-api-client.svg)](https://GitHub.com/jamesrweb/codewars-api-client/graphs/contributors/)
[![GitHub issues](https://img.shields.io/github/issues/jamesrweb/codewars-api-client.svg)](https://GitHub.com/jamesrweb/codewars-api-client/issues/)
[![GitHub pull requests](https://img.shields.io/github/issues-pr/jamesrweb/codewars-api-client.svg)](https://GitHub.com/jamesrweb/codewars-api-client/pulls/)

A library built to interact with the Codewars API and platform.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the library using the following command.

```bash
composer require jamesrweb/codewars-api-client
```

## Basic Usage

Once the package has been installed, we can create the required clients like.

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use CodewarsApiClient\Client;
use CodewarsApiClient\ClientOptions;

$client_options = new ClientOptions("your-api-key");
$client = new Client($client_options);
```

## The `Client`

A `Client` instance allows us to interact with the codewars API in a consistent manner.

### Methods

#### Get information about the user

To get information regarding the user, you can run:

```php
$client->user(string $username);
```

#### Get challenges created by the user

To get a list of challenges the user created, you can run:
```php
$client->authored(string $username);
```

#### Get challenges completed by the user

To get a list of challenges the user completed, you can run:

```php
$client->completed(string $username);
```

#### Get information about a specific challenge

To get an overview regarding a specific challenge, you can run:

```php
$client->challenge(string $id);
```

#### Get information about multiple challenges

To get an overview of multiple challenges at once, you can run:

```php
$client->challenges(array $ids);
```

## Interfaces

There are a number of interfaces exposed for you to use if required. These are namespaced under the `CodewarsApiClient\Interfaces` namespace.

### The `ClientOptionsInterface`

This interface is for the methods that are accessible to use via a `ClientsOptions` instance.

### The `SchemaInterface`

This interface is for the methods required on the items exported from the `CodewarsApiClient\Schemas` namespace.

### The `ClientInterface`

This interface is for the methods that are accessible to use via a `Client` instance.

## Schemas

Schemas allow you to validate any data you may have or want. I have written the Schemas to validate responses from the Codewars API.

Schemas exist under the `CodewarsApiClient\Schemas` namespace and there are currently 4 schemas available for use:

- The `AuthoredChallengesSchema` which validates the shape returned by the API for a set of challenges created by a user
- The `ChallengeSchema` which validates the shape returned by the API for an individual challenge
- The `CompletedChallengesSchema` which validates the shape returned by the API for a set of challenges completed by a user
- The `UserSchema` which validates the shape returned by the API for a user

You can of course create your own schemas by implementing a class of your own that adheres to the `SchemaInterface`, for example:

```php
use CodewarsApiClient\Interfaces\SchemaInterface;

final class MySchema implements SchemaInterface {
    // Implement required methods here
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)