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
 * Trait SandboxTrait
 */
trait SandboxTrait
{
    protected string $sandboxPath = 'sandbox';

    /**
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getSandboxAnalyzerInstancesList(
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
            'getSandboxAnalyzerInstancesList',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->sandboxPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $sandboxId
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getImagesList(
        string $sandboxId,
        ?int $page = null,
        ?int $perPage = null
    ): array
    {
        $params = [
            'sandboxId' => $sandboxId
        ];
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
            'getImagesList',
            $params
        );

        $response = json_decode(
            $this->request(
                $this->sandboxPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $submissionId
     * @return array
     */
    public function getSubmissionStatus(
        string $submissionId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getSubmissionStatus',
            ['submissionId' => $submissionId]
        );

        $response = json_decode(
            $this->request(
                $this->sandboxPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $submissionId
     * @return array
     */
    public function getDetonationDetails(
        string $submissionId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getDetonationDetails',
            ['submissionId' => $submissionId]
        );

        $response = json_decode(
            $this->request(
                $this->sandboxPath,
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
