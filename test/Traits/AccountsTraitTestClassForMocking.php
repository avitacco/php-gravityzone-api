<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test\Traits;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\AccountsTrait;

class AccountsTraitTestClassForMocking
{
    use AccountsTrait;

    public function getId(): string
    {
        return '';
    }
    public function request(string $service, array $params = []): Response
    {
        return new Response();
    }
}
