<?php

require 'vendor/autoload.php';
use Hubleto\Api\Client;

$phpClient = new Client('your-api-key', 'http://localhost/hubleto-project/');

$response = $phpClient->sendRequest('POST', 'Hubleto\\App\\Community\\Contacts', 'GetContacts', []);

echo $response->getBody();