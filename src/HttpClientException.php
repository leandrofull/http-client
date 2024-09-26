<?php

namespace LeandroFull\HttpClient;

final class HttpClientException extends \Exception
{
    public static function endpointWasNotSet(): static
    {
        return new self('The endpoint was not set. Use the \'setEndpoint()\' method.');
    }
}
