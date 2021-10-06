<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use App\Helpers\StringHelper;

class ApiHandler
{
    const MAX_ATTEMPTS = 10;

    /**
     * @var int
     */
    private $failedAttempts;

    /**
     * set defaults
     */
    public function __construct()
    {
        $this->failedAttempts = 1;
    }

    /**
     * @param string $url
     * @return array
     */
    public function fetch(string $url): array
    {
        $response = $this->attempt($url);
        return $this->sanitize($response->json());
    }

    /**
     * @param string $url
     * @return \Illuminate\Http\Client\Response
     */
    private function attempt(string $url): \Illuminate\Http\Client\Response
    {
        $response = Http::get($url);

        if ($this->isCompleted($response)) {
            return $response;
        }

        $this->log($url, $response);
        if ($this->failedAttempts > self::MAX_ATTEMPTS) {
            throw new \Illuminate\Http\Client\HttpClientException('Too many attempts');
        }

        return $this->attempt($url);
    }

    /**
     * @param string $url
     * @param \Illuminate\Http\Client\Response
     */
    private function log(string $url, Response $response): void
    {
        Log::debug("[ApiHandler] Failed retrive data from: $url , Attempts: $this->failedAttempts", $response->json());
        $this->failedAttempts++;
    }

    /**
     * @param \Illuminate\Http\Client\Response $response
     * @return bool
     */
    private function isCompleted(Response $response): bool
    {
        if ($response->failed()) {
            return false;
        }

        $json = $response->json();
        if (isset($json['error'])) {
            return false;
        }

        return true;
    }

    /**
     * Sanitize json payload
     * 
     * @param array $json
     * @return array
     */
    private function sanitize(array $json): array
    {
        foreach ($json as $key => $value) {
            if (is_array($json[$key])) {
                $json[$key] = $this->sanitize($json[$key]);
                continue;
            }

            if (is_string($json[$key])) {
                $json[$key] = StringHelper::getSafeString($value);
            }
        }

        return $json;
    }
}
