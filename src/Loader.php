<?php

require 'vendor/autoload.php';

/**
 * Hubleto API Client for PHP
 * License: See LICENSE.md file in the root folder of the software package.
 */

namespace Hubleto\PhpApiClient;

use GuzzleHttp\Psr7\Request;

class Loader
{

  public string $apiKey;              // Client access API key to be able to send and authenticate requests to Hubleto
  public string $hubletoEndpoint;     // Hubleto instance endpoint
  public object $guzzleClient;        // Guzzle HTTP client object

  /**
   * Constructs a Hubleto PHP API client object
   *
   * @param mixed $config
   * @return void
   */
  public function __construct(array $config)
  {
    $this->apiKey = $config['api_key'];
    $this->hubletoEndpoint = $config['hubleto_endpoint'];
    $this->guzzleClient = new \GuzzleHttp\Client([
      'base_uri' => rtrim($this->hubletoEndpoint, '/') . '/',
      'timeout'  => 30.0,
      'headers'  => [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/json',
        'X-API-KEY'    => 'todo'
        ]
    ]);
  }

  /**
   * Send a request to the Hubleto Instance
   *
   * @param mixed $method HTTP method (GET/POST/PUT/DELETE)
   * @param mixed $app App namespace, e.g. Hubleto\App\Community\Contacts
   * @param mixed $controller Controller in the app namespace, e.g. GetContacts
   * @param mixed $vars Array of request's body parameters.
   * @return object Guzzle's HTTP response object.
   */
  public function sendRequest(string $method, string $app, string $controller, array $vars = []): object
  {
    return $this->guzzleClient->request($method, $this->hubletoEndpoint . '/api/call', [
      'body' => [
        'key' => $this->apiKey,
        'app' => '',
        'controller' => '',
        'vars' => ''
      ]
    ]);
  }

}
