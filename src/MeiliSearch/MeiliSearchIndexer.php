<?php

namespace App\MeiliSearch;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MeiliSearchIndexer implements MeiliSearchInterface
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function createOrUpdate(string $name, $data = []): ResponseInterface
    {
        $response = $this->client->request('PUT', "http://meilisearch:7700/indexes/{$name}/documents", [
            'headers' => [
                'X-Meili-API-Key' => (int)$this->apiKey
            ],
            'body' => json_encode($data)
        ]);
        if ($response->getStatusCode() !== 202) {
            return json_decode($response->getContent(), true);
        }
        throw new \RuntimeException(json_decode($response->getContent(false), true)['message']);
    }
}