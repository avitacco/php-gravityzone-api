<?php
declare(strict_types=1);

namespace IndianaUniversity\GravityZone;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GravityZone
 */
class GravityZone
{
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
            'base_uri' => "https://$host/api/v1.0/jsonrpc",
            'headers' => [
                'Auth' => 'Basic ' . base64_encode("$apiKey:"),
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
    public function get(string $path, array $params = []): ResponseInterface
    {
        return $this->client->get($path, $params);
    }

}
