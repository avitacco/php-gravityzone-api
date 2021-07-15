<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Traits;

use Datto\JsonRpc\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait GeneralTrait
 */
trait GeneralTrait
{
    protected string $generalPath = 'general';

    /**
     * @return array
     */
    public function getApiKeyDetails(): array
    {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getApiKeyDetails',
            []
        );

        $response = json_decode(
            $this->request(
                $this->generalPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param array $params
     * @return ResponseInterface
     */
    abstract public function request(string $service, array $params): ResponseInterface;

    /**
     * @return string
     */
    abstract public function getId(): string;
}
