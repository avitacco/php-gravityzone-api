<?php

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Traits;

use Datto\JsonRpc\Client;
use Psr\Http\Message\ResponseInterface;

trait QuarantineTrait
{
    public function getQuarantineItemsList(
        string $service,
        string $endpointId = null,
        int $page = 1,
        int $perPage = 30,
        array $filters = []
    ): ResponseInterface {
        // I hate doing this here, but if you pass the values as nulls to the
        // api it errors. Need to pass only set params.
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
            uniqid('', true),
            'getQuarantineItemsList',
            $params
        );
        return $this->request(
            "quarantine/$service",
            [
                'json' => $client->preEncode(),
            ]
        );
    }
}
