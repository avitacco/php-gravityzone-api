<?php

declare(strict_types=1);

namespace IndianaUniversity\GravityZone;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use IndianaUniversity\GravityZone\Traits\QuarantineTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GravityZone
 */
class GravityZone
{
    use QuarantineTrait;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * GravityZone constructor.
     * @param string $host
     * @param string $apiKey
     * @param HandlerStack|null $handler
     */
    public function __construct(string $host, string $apiKey, HandlerStack $handler = null)
    {
        $this->client = new Client([
            'base_uri' => "https://$host/api/v1.0/jsonrpc/",
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("$apiKey:"),
                'Content-Type' => 'application/json',
            ],
            'handler' => $handler,
        ]);
    }

    /**
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $path, array $params = []): ResponseInterface
    {
        return $this->client->post($path, $params);
    }
}
