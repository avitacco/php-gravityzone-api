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
 * Trait PoliciesTrait
 */
trait PoliciesTrait
{
    /** @var string */
    protected string $policiesPath = 'policies';

    /**
     * @param string $service
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getPoliciesList(
        string $service,
        ?int $page,
        ?int $perPage
    ): array {
        $params = [];
        $optionalParams = [
            'page',
            'perPage'
        ];
        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getPoliciesList',
            $params
        );
        $response = json_decode(
            $this->request(
                "{$this->policiesPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param string $policyId
     * @return array
     */
    public function getPolicyDetails(
        string $service,
        string $policyId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getPolicyDetails',
            ['policyId' => $policyId]
        );

        $response = json_decode(
            $this->request(
                "{$this->policiesPath}/{$service}",
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
