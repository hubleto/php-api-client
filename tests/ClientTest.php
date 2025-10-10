<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
  public function testGetRequestSendsCorrectDataAndHandlesResponse()
  {
    $mock = new MockHandler([
      new Response(200, ['Content-Type' => 'application/json'], '{"status":"success","data":{"id":123}}'),
    ]);

    $container = [];
    $history = Middleware::history($container);

    $handlerStack = HandlerStack::create($mock);
    $handlerStack->push($history);

    $mockGuzzleClient = new GuzzleClient(['handler' => $handlerStack]);

    $apiClient = new \Hubleto\Api\Client('test-api-key', 'https://fake-hubleto.com', $mockGuzzleClient);

    $response = $apiClient->get('Hubleto\\App\\Community\\Contacts', 'GetContacts', ['filter' => 'active']);

    // Correct data was sent and received
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('{"status":"success","data":{"id":123}}', (string) $response->getBody());

    // Only one request have been sent
    $this->assertCount(1, $container, 'One request should have been sent.');
    $sentRequest = $container[0]['request'];

    $this->assertEquals('GET', $sentRequest->getMethod());
    $this->assertEquals('/api/call', $sentRequest->getUri()->getPath());

    // Verify request body parameters
    parse_str((string) $sentRequest->getBody(), $sentParams);

    $this->assertEquals('test-api-key', $sentParams['key']);
    $this->assertEquals('Hubleto\\App\\Community\\Contacts', $sentParams['app']);
    $this->assertEquals('GetContacts', $sentParams['controller']);
    $this->assertEquals('{"filter":"active"}', $sentParams['vars']);
  }
}
