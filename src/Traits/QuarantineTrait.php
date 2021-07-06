<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Traits;

use Datto\JsonRpc\Client;
use Datto\JsonRpc\Exceptions\ArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait QuarantineTrait
 */
trait QuarantineTrait
{
    /**
     * @param string $service Allowed services are 'computers' and 'exchange'
     * @param string|null $endpointId The ID of the computer for which you want to retrieve the quarantined items
     * @param int $page The results per page
     * @param int $perPage The number of items in a page
     * @param array<string, mixed> $filters Filters to be used when querying the quarantine items list
     * @return string The JSON response from the server
     */
    public function getQuarantineItemsList(
        string $service,
        string $endpointId = null,
        int $page = 1,
        int $perPage = 30,
        array $filters = []
    ): string {
        /*
         * If we pass null values to the API we get errors so it is important to
         * only add params with values. I don't know a better way to accomplish
         * that than this section with the if statements.
         */
        $params = [
            'page' => $page,
            'perPage' => $perPage,
        ];
        if (!is_null($endpointId)) {
            $params['endpointId'] = $endpointId;
        }
        if (count($filters) > 0) {
            $params['filters'] = $filters;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getQuarantineItemsList',
            $params
        );

        return $this->request(
            "quarantine/$service",
            [
                'json' => $client->preEncode(),
            ]
        )->getBody()->getContents();
    }

    /**
     * @param string $service
     * @param array $quarantineItemsIds
     * @return bool
     * @throws ArgumentException
     */
    public function createRemoveQuarantineItemTask(
        string $service,
        array $quarantineItemsIds
    ): bool {
        $client = new Client();
        $client->query(
            $this->getId(),
            'createRemoveQuarantineItemTask',
            [
                'quarantineItemsIds' => $quarantineItemsIds,
            ]
        );

        $response = json_decode(
            $this->request(
                "quarantine/$service",
                [
                    'json' => $client->preEncode(),
                ]
            )->getBody()->getContents()
        );

        if (isset($response->error)) {
            throw new ArgumentException();
        }
        return $response->result;
    }

    /**
     * @param string $service
     * @return bool
     * @throws ArgumentException
     */
    public function createEmptyQuarantineTask(
        string $service
    ): bool {
        $client = new Client();
        $client->query(
            $this->getId(),
            'createEmptyQuarantineTask',
            []
        );

        $response = json_decode(
            $this->request(
                "quarantine/$service",
                [
                    'json' => $client->preEncode(),
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param array $quarantineItemsIds
     * @param string|null $locationToRestore
     * @param bool $addExclusionInPolicy
     * @return bool
     * @throws ArgumentException
     */
    public function createRestoreQuarantineItemTask(
        array $quarantineItemsIds,
        string $locationToRestore = null,
        bool $addExclusionInPolicy = false
    ): bool {
        $params = [
            'quarantineItemsIds' => $quarantineItemsIds,
        ];

        if (!is_null($locationToRestore)) {
            $params['locationToRestore'] = $locationToRestore;
        }

        if ($addExclusionInPolicy) {
            $params['addExclusionInPolicy'] = $addExclusionInPolicy;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createRestoreQuarantineItemTask',
            $params
        );

        $response = json_decode(
            $this->request(
                'quarantine/computers',
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        if (isset($response->error)) {
            throw new ArgumentException();
        }
        return $response->result;
    }

    /**
     * @param array $quarantineItemsIds
     * @param string $username
     * @param string $password
     * @param string|null $email
     * @param string|null $ewsUrl
     * @return bool
     * @throws ArgumentException
     */
    public function createRestoreQuarantineExchangeItemTask(
        array $quarantineItemsIds,
        string $username,
        string $password,
        string $email = null,
        string $ewsUrl = null
    ): bool {
        $params = [
            'quarantineItemsIds' => $quarantineItemsIds,
            'username' => $username,
            'password' => $password
        ];

        if (!is_null($email)) {
            $params['email'] = $email;
        }

        if (!is_null($ewsUrl)) {
            $params['ewsUrl'] = $ewsUrl;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createRestoreQuarantineExchangeItemTask',
            $params
        );

        $response = json_decode(
            $this->request(
                'quarantine/exchange',
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        if (isset($response->error)) {
            throw new ArgumentException();
        }
        return $response->result;
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
