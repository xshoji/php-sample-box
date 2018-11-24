<?php

namespace ComposerProject\Service;

use GuzzleHttp\ClientInterface;

class GetRequestService
{
    /**
     *
     * @var \GuzzleHttp\Client 
     */
    protected $client;

    /**
     * 
     * @param ClientInterface $client
     */
    function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function get(string $uri)
    {
        return $this->client->request("get", $uri)->getBody()->getContents();
    }
}
