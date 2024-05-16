<?php

namespace App\Services;

use GuzzleHttp\Client;


class AzureAISearchService
{
    protected $client;
    protected $endpoint;
    protected $apiKey;
    protected $indexName = 'entries-index';

    public function __construct()
    {
        $this->client = new Client();
        $this->endpoint = env('AZURE_SEARCH_ENDPOINT');
        $this->apiKey = env('AZURE_SEARCH_KEY');
    }

    public function indexData(array $items)
    {
        $documents = array_map(function ($item) {
            return [
                '@search.action' => 'upload',
                'id' => $item['id'],
                'title' => $item['title'],
                'tags' => $item['tags'],
                'primaryTopic' => $item['primaryTopic'],
                'description' => $item['description'],
            ];
        }, $items);

        $response = $this->client->post($this->endpoint . '/indexes/' . $this->indexName . '/docs/index?api-version=2020-06-30', [
            'headers' => [
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
            ],
            'json' => [
                'value' => json_encode($documents),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}

