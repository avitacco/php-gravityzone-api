<?php

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Provider\Web;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use IndianaUniversity\GravityZone\Provider\ProviderInterface;
use Psr\Http\Message\ResponseInterface;

class Web implements ProviderInterface
{
    private Client $client;

    /**
     * Web constructor.
     * @param string $host The FQDN of the host server (e.g. gravityzone.example.net)
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $path, array $params = []): ResponseInterface
    {
        return $this->client->get($path, $params);
    }

    public function put()
    {
        // Do nothing yet
    }
}
