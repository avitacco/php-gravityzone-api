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
 * Trait NetworkTrait
 */
trait NetworkTrait
{
    protected string $path = 'network';

    /**
     * @param string $service
     * @param string|null $parentId
     * @param int|null $viewType
     * @return array
     */
    public function getContainers(
        string $service,
        ?string $parentId = null,
        ?int $viewType = null
    ): array {
        $params = [];
        foreach (['parentId', 'viewType'] as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getContainers',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->path}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $service
     * @param string|null $parentId
     * @param array|null $filters
     * @param int|null $viewType
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getNetworkInventoryItems(
        string $service,
        ?string $parentId = null,
        ?array $filters = null,
        ?int $viewType = null,
        ?int $page = null,
        ?int $perPage = null
    ): array {
        $params = [];
        $optionalParams = [
            'parentId',
            'filters',
            'viewType',
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
            'getNetworkInventoryItems',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->path}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param array $targetIds
     * @param int $type
     * @param array $customScanSettings
     * @param string|null $name
     * @return bool
     */
    public function createScanTask(
        string $service,
        array $targetIds,
        int $type,
        array $customScanSettings,
        ?string $name = null
    ): bool {
        $params = [
            'targetIds' => $targetIds,
            'type' => $type,
            'customScanSettings' => $customScanSettings,
        ];

        if (!is_null($name)) {
            $params['name'] = $name;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createScanTask',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->path}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    public function createReconfigureClientTask()
    {
    }

    public function getScanTasksList()
    {
    }

    public function getEndpointsList()
    {
    }

    public function getManagedEndpointDetails()
    {
    }

    public function createCustomGroup()
    {
    }

    public function deleteCustomGroup()
    {
    }

    public function moveCustomGroup()
    {
    }

    public function moveEndpoints()
    {
    }

    public function deleteEndpoint()
    {
    }

    public function setEndpointLabel()
    {
    }

    public function createScanTaskByMac()
    {
    }

    public function assignPolicy()
    {
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
