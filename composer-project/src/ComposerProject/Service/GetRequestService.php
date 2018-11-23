<?php

namespace ComposerProject\Service;

use \GuzzleHttp\Client;

class WikipediaService
{
    /**
     *
     * @var \GuzzleHttp\Client 
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function get(string $uri)
    {
        return $this->client->get($uri)->getBody();
    }
}
