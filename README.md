# Http Client

## Requirements:
- PHP 8.2
- Curl Extension
- Json Extension

## Example:

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

$api = new TestClient();
var_dump($api->test1());
var_dump($api->test2());
```

## Client Methods:
1. run()
2. setEndpoint(endpoint: string)
3. unsetEndpoint()
4. getEndpoint()
5. setHeader(key: string, value: string)
6. getHeader(key: string)
7. unsetHeader(key: string)
8. unsetAllHeaders()
9. getAllHeaders()
10. setBody(body: string|array)
11. unsetBody()
12. getBody()
13. setMethod(method: string)
14. getMethod()
15. unsetMethod()
16. setTimeout(timeout: int)
17. getTimeout()
18. unsetTimeout()
19. setQuery(key: string, value: string)
20. getQuery()
21. unsetQuery(key: string)
22. unsetAllQueries()
23. getAllQueries()
24. setCookie(key: string, value: string)
25. getCookie(key: string)
26. unsetCookie(key: string)
27. unsetAllCookies()
28. getAllCookies()
29. setUserAgent(userAgent: string)
30. getUserAgent()
31. unsetUserAgent()
32. setPayload(payload: array)
33. get(endpoint: string)
34. post(endpoint: string)
35. put(endpoint: string)
36. patch(endpoint: string)
37. delete(endpoint: string)