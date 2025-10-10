<?php

namespace Hubleto\Api;

use GuzzleHttp\Psr7\Response;

/**
 * Hubleto API Client for PHP
 */

class Client
{

  private string $apiKey;              // Client access API key to be able to send and authenticate requests to Hubleto
  private string $hubletoEndpoint;     // Hubleto instance endpoint
  private \GuzzleHttp\Client $guzzleClient;        // Guzzle HTTP client object

  /**
   * Constructs a Hubleto PHP API client object
   *
   * @param string $apiKey
   * @param string $hubletoEndpoint
   * @param \GuzzleHttp\Client|null $guzzleClient Optional Guzzle client for dependency injection (for testing)
   * @return void
   */
  public function __construct(string $apiKey, string $hubletoEndpoint, ?\GuzzleHttp\Client $guzzleClient = null)
  {
    $this->apiKey = $apiKey;
    $this->hubletoEndpoint = $hubletoEndpoint;

    $this->guzzleClient = $guzzleClient ?: new \GuzzleHttp\Client([
      'base_uri' => rtrim($this->hubletoEndpoint, '/') . '/',
      'timeout'  => 30.0,
      'headers'  => [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/json',
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
   * @return Response Guzzle's HTTP response object.
   */
  public function sendRequest(string $method, string $app, string $controller, array $vars = []): Response
  {
    return $this->guzzleClient->request($method, $this->hubletoEndpoint . '/api/call', [
      'form_params' => [
        'key' => $this->apiKey,
        'app' => $app,
        'controller' => $controller,
        'vars' => json_encode($vars)
      ]
    ]);
  }

  /**
   * Sends a GET request to the specified app and controller.
   *
   * @param string $app App namespace, e.g. Hubleto\App\Community\Contacts
   * @param string $controller Controller in the app namespace, e.g. GetContacts
   * @param array $vars Optional request body parameters
   * @return Response Guzzle's HTTP response object
   */
  public function get(string $app, string $controller, array $vars = []): Response {
    return $this->sendRequest('GET', $app, $controller, $vars);
  }

  /**
   * Sends a POST request to the specified app and controller.
   *
   * @param string $app App namespace, e.g. Hubleto\App\Community\Contacts
   * @param string $controller Controller in the app namespace, e.g. GetContacts
   * @param array $vars Optional request body parameters
   * @return Response Guzzle's HTTP response object
   */
  public function post(string $app, string $controller, array $vars = []): Response {
    return $this->sendRequest('POST', $app, $controller, $vars);
  }

}
