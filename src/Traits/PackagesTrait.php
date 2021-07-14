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
 * Trait PackagesTrait
 */
trait PackagesTrait
{
    protected string $packagesPath = 'packages';

    /**
     * @param string|null $packageName
     * @return array
     */
    public function getInstallationLinks(
        ?string $packageName = null
    ): array {
        $params = [];
        if (!is_null($packageName)) {
            $params['packageName'] = $packageName;
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'getInstallationLinks',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->packagesPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getPackagesList(
        ?int $page = null,
        ?int $perPage = null
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
            'getPackagesList',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->packagesPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $packageName
     * @param string|null $description
     * @param string|null $language
     * @param array|null $modules
     * @param array|null $scanMode
     * @param array|null $settings
     * @param array|null $roles
     * @param array|null $deploymentOptions
     * @return array
     */
    public function createPackage(
        string $packageName,
        ?string $description = null,
        ?string $language = null,
        ?array $modules = null,
        ?array $scanMode = null,
        ?array $settings = null,
        ?array $roles = null,
        ?array $deploymentOptions = null
    ): array {
        $params = [
            'packageName' => $packageName
        ];
        $optionalParams = [
            'description',
            'language',
            'modules',
            'scanMode',
            'settings',
            'roles',
            'deploymentOptions'
        ];
        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createPackage',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->packagesPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $packageId
     */
    public function deletePackage(
        string $packageId
    ): void {
        $client = new Client();
        $client->query(
            $this->getId(),
            'deletePackage',
            ['packageId' => $packageId]
        );

        $this->request(
            $this->packagesPath,
            [
                'json' => $client->preEncode()
            ]
        );

        return;
    }

    /**
     * @param string $packageId
     * @return array
     */
    public function getPackageDetails(
        string $packageId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getPackageDetails',
            ['packageId' => $packageId]
        );

        $response = json_decode(
            $this->request(
                $this->packagesPath,
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
