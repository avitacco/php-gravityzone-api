<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use IndianaUniversity\GravityZone\Traits\AccountsTrait;
use IndianaUniversity\GravityZone\Traits\QuarantineTrait;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class GravityZone
 */
class GravityZone
{
    use AccountsTrait;
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
     * Get a new Time-Based UUID for a request.
     * This is here so it can be mocked with a more predictable output in tests
     * @return string
     */
    public function getId(): string
    {
        return Uuid::uuid1()->toString();
    }

    /**
     * @param string $path
     * @param array<string, mixed> $params
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $path, array $params = []): ResponseInterface
    {
        return $this->client->post($path, $params);
    }
}
