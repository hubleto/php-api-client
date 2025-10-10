# php-api-client

A PHP API client for Hubleto, designed to simplify integration with Hubleto’s services.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Requirements](#requirements)
- [Usage](#usage)
- [Configuration](#configuration)
- [API Reference](#api-reference)
- [Contact](#contact)

## Installation

Install via Composer:

```bash
composer require hubleto/php-api-client
```

## Requirements

- PHP 7.4 or higher
- Composer
- GuzzleHTTP (installed automatically via Composer dependencies)

## Usage

```php
require 'vendor/autoload.php';
use Hubleto\Api\Client;


$phpClient = new Client('your-api-key', 'http://localhost/hubleto/erp-project/');

$response = $phpClient->sendRequest('POST', 'Hubleto\\App\\Community\\Contacts', 'GetContacts', []);

// Example POST request
$response = $client->post('Hubleto\App\Community\Contacts', 'CreateContact', ['name' => 'John Doe']);

echo $response->getBody();
```

See the [examples](examples/) directory for more usage examples.

## Configuration

You can configure the client by passing options to the constructor:

```php
$client = new Client('your-api-key', 'http://localhost/hubleto/erp-project/');
```

## API Reference

### Client

#### `__construct(string $apiKey, string $baseUrl)`

Creates a new API client instance.

#### `get(string $app, string $controller, array $vars = [])`

Sends a GET request. Uses the sendRequest method internally.

#### `post(string $app, string $controller, array $vars = [])`

Sends a POST request. Uses the sendRequest method internally.

#### `sendRequest(string $method, string $app, string $controller, array $vars = [])`

Sends an HTTP request with the specified method (GET, POST, etc.) to the given app and controller, with optional parameters.

## Contact

For questions or support, please contact us at [https://hubleto.com/en/contact](https://hubleto.com/en/contact).
