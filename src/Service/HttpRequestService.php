<?php
declare(strict_types=1);

namespace Wpsync\Service;

use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Wpsync\Configuration;

class HttpRequestService
{
    private RetryableHttpClient $client;

    public function __construct()
    {
        $this->client = (new HttpClientService())->getClient();
    }

    public function makeRequest(): array
    {
        do {
            $response = $this->client->request(
                method: Configuration::getParameter('apiMethod'),
                url: Configuration::getParameter('apiURL'),
                options: Configuration::getParameter('apiOptions'));

            $statusCode = $response->getStatusCode();
            $newProducts = $this->transformToProducts($response);
            var_dump(count($newProducts)); // TODO remove
            var_dump($statusCode);
        } while ($statusCode !== 200);

        return $newProducts;
    }

    public function transformToProducts(ResponseInterface $response): array
    {
        $data = $response->toArray();

        return $data['data'];
    }
}
