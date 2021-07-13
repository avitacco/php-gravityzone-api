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
    protected string $networkPath = 'network';

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
                "{$this->networkPath}/{$service}",
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
                "{$this->networkPath}/{$service}",
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
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $service
     * @param array $targetIds
     * @param array|null $scheduler
     * @param array|null $modules
     * @param array|null $scanMode
     * @param array|null $roles
     * @return bool
     */
    public function createReconfigureClientTask(
        string $service,
        array $targetIds,
        ?array $scheduler = null,
        ?array $modules = null,
        ?array $scanMode = null,
        ?array $roles = null
    ): bool {
        $params = [
            'targetIds' => $targetIds
        ];
        $optionalParams = [
            'scheduler',
            'modules',
            'scanMode',
            'roles'
        ];
        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createReconfigureClientTask',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $service
     * @param string|null $name
     * @param int|null $status
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getScanTasksList(
        string $service,
        ?string $name = null,
        ?int $status = null,
        ?int $page = null,
        ?int $perPage = null
    ): array {
        $params = [];
        $optionalParams = [
            'name',
            'status',
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
            'getScanTasksList',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param string|null $parentId
     * @param bool|null $isManaged
     * @param int|null $viewType
     * @param int|null $page
     * @param int|null $perPage
     * @param array|null $filters
     * @return array
     */
    public function getEndpointsList(
        string $service,
        ?string $parentId = null,
        ?bool $isManaged = null,
        ?int $viewType = null,
        ?int $page = null,
        ?int $perPage = null,
        ?array $filters = null
    ): array {
        $params = [];
        $optionalParams = [
            'parentId',
            'isManaged',
            'viewType',
            'page',
            'perPage',
            'filters'
        ];
        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getEndpointsList',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param string $endpointId
     * @return array
     */
    public function getManagedEndpointDetails(
        string $service,
        string $endpointId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getManagedEndpointDetails',
            ['endpointId' => $endpointId]
        );

        $response = json_decode(
            $this->request(
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $service
     * @param string $groupName
     * @param string|null $parentId
     * @return string
     */
    public function createCustomGroup(
        string $service,
        string $groupName,
        ?string $parentId = null
    ): string {
        $params = [
            'groupName' => $groupName
        ];
        if (!is_null($parentId)) {
            $params['parentId'] = $parentId;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createCustomGroup',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->networkPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $service
     * @param string $groupId
     * @param bool|null $force
     */
    public function deleteCustomGroup(
        string $service,
        string $groupId,
        ?bool $force = null
    ): void {
        $params = [
            'groupId' => $groupId
        ];
        if (!is_null($force)) {
            $params['force'] = $force;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'deleteCustomGroup',
            $params
        );

        $this->request(
            "{$this->networkPath}/{$service}",
            [
                'json' => $client->preEncode()
            ]
        );

        return;
    }

    /**
     * @param string $service
     * @param string $groupId
     * @param string $parentId
     */
    public function moveCustomGroup(
        string $service,
        string $groupId,
        string $parentId
    ): void {
        $params = [
            'groupId' =>  $groupId,
            'parentId' => $parentId
        ];

        $client = new Client();
        $client->query(
            $this->getId(),
            'moveCustomGroup',
            $params
        );

        $this->request(
            "{$this->networkPath}/{$service}",
            [
                'json' => $client->preEncode()
            ]
        );

        return;
    }

    /**
     * @param string $service
     * @param array $endpointIds
     * @param string $groupId
     */
    public function moveEndpoints(
        string $service,
        array $endpointIds,
        string $groupId
    ): void {
        $params = [
            'endpointIds' => $endpointIds,
            'groupId' => $groupId
        ];

        $client = new Client();
        $client->query(
            $this->getId(),
            'moveEndpoints',
            $params
        );

        $this->request(
            "{$this->networkPath}/{$service}",
            [
                'json' => $client->preEncode()
            ]
        );

        return;
    }

    /**
     * @param string $service
     * @param string $endpointId
     */
    public function deleteEndpoint(
        string $service,
        string $endpointId
    ): void {
        $client = new Client();
        $client->query(
            $this->getId(),
            'deleteEndpoint',
            ['endpointId' => $endpointId]
        );

        $this->request(
            "{$this->networkPath}/{$service}",
            [
                'json' => $client->preEncode()
            ]
        );

        return;
    }

    /**
     * @param string $endpointId
     * @param string $label
     * @return bool
     */
    public function setEndpointLabel(
        string $endpointId,
        string $label
    ): bool {
        $params = [
            'endpointId' => $endpointId,
            'label' => $label
        ];

        $client = new Client();
        $client->query(
            $this->getId(),
            'setEndpointLabel',
            $params
        );

        $response = json_decode(
            $this->request(
                'network',
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
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
