<?php

namespace LeandroFull\HttpClient;

class HttpResponse
{
    public readonly bool $error;

    public function __construct(
        public readonly int $status = 0,
        public readonly ?string $data = null,
        public readonly ?string $errorMessage = null,
        public readonly ?array $info = null,
    )
    {
        $this->error = $errorMessage === null ? false : true;
    }

    public function json(): ?array
    {
        if ($this->data === null) return null;
        $data = json_decode($this->data, true);
        if (!$data) return null;
        return $data;
    }
}
