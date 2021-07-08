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
 * Trait AccountsTrait
 */
trait AccountsTrait
{
    protected string $path = 'accounts';

    /**
     * @param int $page
     * @param int $perPage
     * @return string
     */
    public function getAccountsList(int $page = 1, int $perPage = 30): string
    {
        $params = [
            'page' => $page,
            'perPage' => $perPage,
        ];

        $client = new Client();
        $client->query(
            $this->getId(),
            'getAccountsList',
            $params
        );

        return $this->request(
            $this->path,
            [
                'json' => $client->preEncode(),
            ]
        )->getBody()->getContents();
    }

    /**
     * @param string $accountId
     */
    public function deleteAccount(string $accountId): void
    {
        $client = new Client();
        $client->query(
            $this->getId(),
            'deleteAccount',
            [
                'accountId' => $accountId
            ]
        );

        $this->request(
            $this->path,
            [
                'json' => $client->preEncode()
            ]
        )->getBody()->getContents();

        return;
    }

    /**
     * @param string $email
     * @param string $userName
     * @param array $profile
     * @param string|null $password
     * @param int|null $role
     * @param array|null $rights
     * @param array|null $targetIds
     * @return string
     */
    public function createAccount(
        string $email,
        string $userName,
        array $profile,
        ?string $password = null,
        ?int $role = null,
        ?array $rights = null,
        ?array $targetIds = null
    ): string {
        $params = [
            'email' => $email,
            'userName' => $userName,
            'profile' => $profile
        ];

        foreach (['password', 'role', 'rights', 'targetIds'] as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createAccount',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->path,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $accountId
     * @param string|null $email
     * @param string|null $userName
     * @param string|null $password
     * @param array|null $profile
     * @param int|null $role
     * @param array|null $rights
     * @param array|null $targetIds
     * @return bool
     */
    public function updateAccount(
        string $accountId,
        ?string $email = null,
        ?string $userName = null,
        ?string $password = null,
        ?array $profile = null,
        ?int $role = null,
        ?array $rights = null,
        ?array $targetIds = null
    ): bool {
        $params = [
            'accountId' => $accountId
        ];
        $optionalParams = [
            'email',
            'userName',
            'password',
            'profile',
            'role',
            'rights',
            'targetIds',
        ];

        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'updateAccount',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->path,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );
        return $response->result;
    }

    /**
     * @param string|null $accountId
     * @param int|null $deleteAfter
     * @param array|null $emailAddresses
     * @param bool|null $includeDeviceName
     * @param bool|null $includeDeviceFQDN
     * @param array|null $notificationsSettings
     * @return bool
     */
    public function configureNotificationsSettings(
        ?string $accountId = null,
        ?int $deleteAfter = null,
        ?array $emailAddresses = null,
        ?bool $includeDeviceName = null,
        ?bool $includeDeviceFQDN = null,
        ?array $notificationsSettings = null
    ): bool {
        $params = [];
        $optionalParams = [
            'accountId',
            'deleteAfter',
            'emailAddresses',
            'includeDeviceName',
            'includeDeviceFQDN',
            'notificationsSettings',
        ];

        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'configureNotificationsSettings',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->path,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    public function getNotificationsSettings(
        ?string $accountId = null
    ): array {
        $params = [];
        if (!is_null($accountId)) {
            $params['accountId'] = $accountId;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getNotificationsSettings',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->path,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents(),
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
