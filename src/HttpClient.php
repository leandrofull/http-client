<?php

namespace LeandroFull\HttpClient;

class HttpClient extends AbstractHttpClient
{
    public const GET = 'GET';

    public const POST = 'POST';

    public const PATCH = 'PATCH';

    public const PUT = 'PUT';

    public const DELETE = 'DELETE';

    public function __construct(private readonly string $baseUrl = '')
    {
        parent::__construct();
    }

    public static function getJson(string $url, string $method, ?array $payload = null): ?array
    {
        $client = (new self())->setEndpoint($url)->setMethod($method);
        if ($payload !== null) $client->setPayload($payload);
        return $client->run()->json();
    }

    #[\Override]
    public function setEndpoint(string $endpoint): static
    {
        parent::setEndpoint("{$this->baseUrl}{$endpoint}");
        return $this;
    }
    
    public function setPayload(array $payload): static
    {
        $json = json_encode($payload, JSON_THROW_ON_ERROR);
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->setBody($json);
        return $this;
    }

    public function get(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod(self::GET)
            ->run();
    }

    public function post(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod(self::POST)
            ->run();
    }

    public function put(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod(self::PUT)
            ->run();
    }

    public function patch(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod(self::PATCH)
            ->run();
    }

    public function delete(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod(self::DELETE)
            ->run();
    }
}
