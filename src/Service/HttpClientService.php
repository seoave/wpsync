<?php
declare(strict_types=1);

namespace Wpsync\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\RetryableHttpClient;

class HttpClientService
{
    private RetryableHttpClient $client;

    public function __construct()
    {
        $this->client = new RetryableHttpClient(HttpClient::create());
    }

    /**
     * @return RetryableHttpClient
     */
    public function getClient(): RetryableHttpClient
    {
        return $this->client;
    }
}
