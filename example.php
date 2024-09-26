<?php

use LeandroFull\HttpClient\HttpClient;

require __DIR__ . '/vendor/autoload.php';

final class TestClientException extends \Exception
{
    public static function unexpectedValue(): static
    {
       return new self("Unexpected value. Try again.");
    }
}

class TestClient
{
    private static HttpClient $client;

    public function __construct()
    {
        if (!isset(self::$client)) {
            self::$client = new HttpClient('http://localhost:8080');
            self::$client->setTimeout(5);
        }
    }

    private function client(): HttpClient
    {   
        return self::$client->unsetAllHeaders()
            ->unsetAllQueries()
            ->unsetBody();
    }

    public function test1(): array
    {
        // GET http://localhost:8080/test1?filter=test
        $response = $this->client()->setQuery('filter', 'test')->get('/test1');
        if ($response->status !== 200) throw TestClientException::unexpectedValue();
        return $response->json();
    }

    public function test2(): array
    {
        // POST http://localhost:8080/test2 / Content-Type: application/json; charset=utf-8
        $response = $this->client()->setPayload(["filter" => "test"])->post('/test2');
        if ($response->status !== 200) throw TestClientException::unexpectedValue();
        return $response->json();
    }
}

$api = new TestClient();
var_dump($api->test1());
var_dump($api->test2());
