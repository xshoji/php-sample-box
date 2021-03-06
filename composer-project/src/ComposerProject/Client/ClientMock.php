<?php

namespace ComposerProject\Client;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Response;

class ClientMock implements \GuzzleHttp\ClientInterface
{

    /**
     * Send an HTTP request.
     *
     * @param \Psr\Http\Message\RequestInterface $request Request to send
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(\Psr\Http\Message\RequestInterface $request, array $options = [])
    {
        return new Response();
    }

    /**
     * Asynchronously send an HTTP request.
     *
     * @param \Psr\Http\Message\RequestInterface $request Request to send
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsync(\Psr\Http\Message\RequestInterface $request, array $options = [])
    {
        return new Promise();
    }

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string $method HTTP method.
     * @param string|\Psr\Http\Message\UriInterface $uri URI object or string.
     * @param array $options Request options to apply.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, array $options = [])
    {
        return new Response();
    }

    /**
     * Create and send an asynchronous HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well. Use an array to provide a URL
     * template and additional variables to use in the URL template expansion.
     *
     * @param string $method HTTP method
     * @param string|\Psr\Http\Message\UriInterface $uri URI object or string.
     * @param array $options Request options to apply.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestAsync($method, $uri, array $options = [])
    {
        return new Promise();
    }

    /**
     * Get a client configuration option.
     *
     * These options include default request options of the client, a "handler"
     * (if utilized by the concrete client), and a "base_uri" if utilized by
     * the concrete client.
     *
     * @param string|null $option The config option to retrieve.
     *
     * @return mixed
     */
    public function getConfig($option = null)
    {
        return null;
    }
}