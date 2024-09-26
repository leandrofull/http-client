<?php

namespace LeandroFull\HttpClient;

abstract class AbstractHttpClient
{
    /**
     * @var \CurlHandle $ch
     */
    private readonly \CurlHandle $ch;

    public function __construct()
    {
        $this->ch = curl_init();
    }

    public function reset(): static
    {
        curl_reset($this->ch);
        return $this;
    }

    public function run(): HttpResponse
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->endpoint === null) throw HttpClientException::endpointWasNotSet();
        $query = '';
        if (count($this->query) > 0) $query = '?'.http_build_query($this->query);
        curl_setopt($this->ch, CURLOPT_URL, "{$this->endpoint}{$query}");
        if (count($this->headers) > 0) curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);
        if ($this->body !== null) curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->body);
        if ($this->userAgent !== null) curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        
        if (count($this->cookies) > 0) {
            $cookies = implode('; ', $this->cookies);
            curl_setopt($this->ch, CURLOPT_COOKIE, $cookies);
        }

        if ($this->timeout !== null) {
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
            curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        }

        $response = curl_exec($this->ch);
        $errorMessage = curl_error($this->ch);
        $info = curl_getinfo($this->ch);
        $status = 0;
        if (!is_string($response)) $response = null;
        if (empty($errorMessage)) $errorMessage = null;

        if ($errorMessage === null) {
            $status = $info['http_code'];
        } else {
            $info = null;
        }

        $this->reset();
        return new HttpResponse($status, $response, $errorMessage, $info);
    }

    /**
     * @var ?string $endpoint
     */
    private ?string $endpoint = null;

    public function setEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function unsetEndpoint(): static
    {
        $this->endpoint = null;
        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    /**
     * @var string[] $headers
     */
    private array $headers = [];
    
    public function setHeader(string $key, string $value): static
    {
        $value = empty($key) ? $value : "$key: $value";
        $this->headers[$key] = $value;
        return $this;
    }
    
    public function getHeader(string $key): ?string
    {
        return $this->headers[$key] ?? null;
    }

    public function unsetHeader(string $key): static
    {
        if (isset($this->headers[$key])) unset($this->headers[$key]);
        return $this;
    }

    public function unsetAllHeaders(): static
    {
        $this->headers = [];
        return $this;
    }

    public function getAllHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @var array|string|null $body
     */
    private array|string|null $body = null;

    public function setBody(array|string $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function unsetBody(): static
    {
        $this->body = null;
        return $this;
    }

    public function getBody(): array|string|null
    {
        return $this->body;
    }
    
    /**
     * @var string $method
     */
    private string $method = 'GET';

    public function setMethod(string $method): static
    {
        $this->method = $method;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function unsetMethod(): static
    {
        $this->method = 'GET';
        return $this;
    }

    /**
     * @var int $timeout
     */
    private ?int $timeout = null;

    public function setTimeout(int $timeout): static
    {
        if ($timeout < 0) $timeout = 0;
        $this->timeout = $timeout;
        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function unsetTimeout(): static
    {
        $this->timeout = null;
        return $this;
    }

    /**
     * @var string[] $query
     */
    private array $query = [];

    public function setQuery(string $key, string $value): static
    {
        $this->query[$key] = $value;
        return $this;
    }
    
    public function getQuery(string $key): ?string
    {
        return $this->query[$key] ?? null;
    }

    public function unsetQuery(string $key): static
    {
        if (isset($this->query[$key])) unset($this->query[$key]);
        return $this;
    }

    public function unsetAllQueries(): static
    {
        $this->query = [];
        return $this;
    }

    public function getAllQueries(): array
    {
        return $this->query;
    }

    /**
     * @var string[] $cookies
     */
    private array $cookies = [];

    public function setCookie(string $key, string $value): static
    {
        $value = "$key=$value";
        $this->cookies[$key] = $value;
        return $this;
    }
    
    public function getCookie(string $key): ?string
    {
        return $this->cookies[$key] ?? null;
    }

    public function unsetCookie(string $key): static
    {
        if (isset($this->cookies[$key])) unset($this->cookies[$key]);
        return $this;
    }

    public function unsetAllCookies(): static
    {
        $this->cookies = [];
        return $this;
    }

    public function getAllCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @var string $userAgent
     */
    private ?string $userAgent = null;

    public function setUserAgent(string $userAgent): static
    {
        $this->userAgent = $userAgent;
        return $this;
    }
    
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function unsetUserAgent(): static
    {
        $this->userAgent = null;
        return $this;
    }
}
