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
 * Trait ReportsTrait
 */
trait ReportsTrait
{
    /** @var string */
    protected string $reportsPath = 'reports';

    /**
     * @param string $service
     * @param string $name
     * @param int $type
     * @param array $targetIds
     * @param array|null $scheduledInfo
     * @param array|null $options
     * @param array|null $emailsList
     * @return string
     */
    public function createReport(
        string $service,
        string $name,
        int $type,
        array $targetIds,
        ?array $scheduledInfo = null,
        ?array $options = null,
        ?array $emailsList = null
    ): string {
        $params = [
            'name' => $name,
            'type' => $type,
            'targetIds' => $targetIds
        ];
        $optionalParams = [
            'scheduledInfo',
            'options',
            'emailsList'
        ];
        foreach ($optionalParams as $param) {
            if (!is_null($$param)) {
                $params[$param] = $$param;
            }
        }

        $client = new Client();
        $client->query(
            $this->getId(),
            'createReport',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->reportsPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return $response->result;
    }

    /**
     * @param string $service
     * @param int $type
     * @param string|null $name
     * @param int|null $page
     * @param int|null $perPage
     * @return array
     */
    public function getReportsList(
        string $service,
        int $type,
        ?string $name = null,
        ?int $page = null,
        ?int $perPage = null
    ): array {
        $params = [
            'type' => $type
        ];
        $optionalParams = [
            'name',
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
            'getReportsList',
            $params
        );

        $response = json_decode(
            $this->request(
                "{$this->reportsPath}/{$service}",
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );

        return (array)$response->result;
    }

    /**
     * @param string $reportId
     * @return array
     */
    public function getDownloadLinks(
        string $reportId
    ): array {
        $client = new Client();
        $client->query(
            $this->getId(),
            'getDownloadLinks',
            ['reportId' => $reportId]
        );

        $response = json_decode(
            $this->request(
                $this->reportsPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );
        return (array)$response->result;
    }

    /**
     * @param string $reportId
     * @return bool
     */
    public function deleteReport(
        string $reportId
    ): bool {
        $client = new Client();
        $client->query(
            $this->getId(),
            'deleteReport',
            ['reportId' => $reportId]
        );

        $response = json_decode(
            $this->request(
                $this->reportsPath,
                [
                    'json' => $client->preEncode()
                ]
            )->getBody()->getContents()
        );
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
