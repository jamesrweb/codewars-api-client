# Codewars Kata Exporter

A wrapper for the Codewars API.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the library using the following command.

```bash
composer require jamesrweb/codewars-kata-exporter
```

## Usage

Once the package has been installed, we can create a client for our requests like in the example shown below.

```php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use CodewarsKataExporter\Client;
use CodewarsKataExporter\ClientOptions;
use Symfony\Component\HttpClient\HttpClient;

$http_client = HttpClient::create();
$client_options = new ClientOptions("username", "api-key");
$client = new Client($http_client, $client_options);
```

## Client methods

### Get information about the user

To get information regarding the user that was passed to the constructor you can run:

```php
$client->userOverview();
```

### Get challenges created by the user

To get a list of challenges the user created, you can run:
```php
$client->authoredChallenges();
```

### Get challenges completed by the user

To get a list of challenges the user completed, you can run:

```php
$client->completedChallenges();
```

### Get information about a specific challenge

To get an overview regarding a specific challenge, for example one the user completed, you can run:

```php
$client->challenge(string $challenge_id);
```



## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)