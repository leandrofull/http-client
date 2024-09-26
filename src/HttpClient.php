<?php

namespace LeandroFull\HttpClient;

class HttpClient extends AbstractHttpClient
{
    public function __construct(private readonly string $baseUrl = '')
    {
        parent::__construct();
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
            ->setMethod('GET')
            ->run();
    }

    public function post(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod('POST')
            ->run();
    }

    public function put(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod('PUT')
            ->run();
    }

    public function patch(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod('PATCH')
            ->run();
    }

    public function delete(string $endpoint = ''): HttpResponse
    {
        return $this->setEndpoint($endpoint)
            ->setMethod('DELETE')
            ->run();
    }
}
