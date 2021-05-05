<?php

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Traits;

use Datto\JsonRpc\Client;
use Psr\Http\Message\ResponseInterface;

trait AccountsTrait
{
    protected string $path = 'accounts';

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

    public function deleteAccount(): string
    {
        return 'Fill this function';
    }

    public function createAccount(): string
    {
        return 'Fill this function';
    }

    public function updateAccount(): string
    {
        return 'Fill this function';
    }

    public function configureNotificationSettings(): string
    {
        return 'Fill this function';
    }

    public function getNotificationSettings(): string
    {
        return 'Fill this function';
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
