<?php

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Traits;

use Datto\JsonRpc\Client;
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
     * @param array $params
     * @return ResponseInterface
     */
    abstract public function request(string $service, array $params): ResponseInterface;

    /**
     * @return string
     */
    abstract public function getId(): string;
}
