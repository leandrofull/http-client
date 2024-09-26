# Http Client

## Requirements
- PHP 8.2
- Curl Extension
- Json Extension
- Composer

## Install
```
composer require leandrofull/http-client
```

## Example

```php
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

$client = new TestClient();
var_dump($client->test1());
var_dump($client->test2());
```

## HttpClient
### Constants
1. HttpClient::GET
2. HttpClient::POST
3. HttpClient::PATCH
4. HttpClient::PUT
5. HttpClient::DELETE
### Methods
1. run(): HttpResponse
2. setEndpoint(endpoint: string): HttpClient
3. unsetEndpoint(): HttpClient
4. getEndpoint(): string|null
5. setHeader(key: string, value: string): HttpClient
6. getHeader(key: string): string|null
7. unsetHeader(key: string): HttpClient
8. unsetAllHeaders(): HttpClient
9. getAllHeaders(): array
10. setBody(body: string|array): HttpClient
11. unsetBody(): HttpClient
12. getBody(): array|string|null
13. setMethod(method: string): HttpClient
14. getMethod(): string
15. unsetMethod(): HttpClient
16. setTimeout(timeout: int): HttpClient
17. getTimeout(): int|null
18. unsetTimeout(): HttpClient
19. setQuery(key: string, value: string): HttpClient
20. getQuery(): string|null
21. unsetQuery(key: string): HttpClient
22. unsetAllQueries(): HttpClient
23. getAllQueries(): array
24. setCookie(key: string, value: string): HttpClient
25. getCookie(key: string): string|null
26. unsetCookie(key: string): HttpClient
27. unsetAllCookies(): HttpClient
28. getAllCookies(): array
29. setUserAgent(userAgent: string): HttpClient
30. getUserAgent(): string|null
31. unsetUserAgent(): HttpClient
32. setPayload(payload: array): HttpClient
33. get(endpoint: string): HttpResponse
34. post(endpoint: string): HttpResponse
35. put(endpoint: string): HttpResponse
36. patch(endpoint: string): HttpResponse
37. delete(endpoint: string): HttpResponse
38. reset(): HttpClient
39. static getJson(url: string, method: string, payload: array|null): array|null

## HttpResponse
### Properties
1. status: int
2. data: string|null
3. errorMessage: string|null
4. error: bool
5. info: array|null
### Methods
1. json(): array|null