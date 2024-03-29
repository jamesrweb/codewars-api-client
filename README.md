# Codewars API Client

[![Test coverage](https://img.shields.io/badge/test%20coverage-100%25-brightgreen.svg)](https://github.com/jamesrweb/codewars-api-client)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fjamesrweb%2Fcodewars-api-client%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/jamesrweb/codewars-api-client/master)
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

$client = new Client("your-api-key");
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
$client->challenges(array<string> $ids);
```

## Interfaces

There are a number of interfaces exposed for you to use if required. These are namespaced under the `CodewarsApiClient\Interfaces` namespace.

### The `ChallengeInterface`

This interface is for the methods that access challenge specific data.

### The `UserInterface`

This interface is for the methods that access user specific data.

### The `ClientInterface`

This interface is for the methods that are accessible to use via a `Client` instance and is contains all methods defined in the `ChallengeInterface` and `UserInterface` interfaces.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

This project uses [an MIT license](https://choosealicense.com/licenses/mit/). If you wish to view [the license](https://github.com/jamesrweb/codewars-api-client/blob/master/LICENSE), it can be found in the project root.
