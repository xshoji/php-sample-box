<?php

namespace ComposerProject\Service;

use \GuzzleHttp\Client;

class GetRequestService
{
    /**
     *
     * @var \GuzzleHttp\Client 
     */
    protected $client;

    /**
     * 
     * @param Client $client
     */
    function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function get(string $uri)
    {
        return $this->client->get($uri)->getBody()->getContents();
    }
}
