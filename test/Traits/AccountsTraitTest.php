<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\AccountsTrait;
use PHPUnit\Framework\TestCase;

class AccountsTraitTest extends TestCase
{

    public function testGetAccountsList()
    {
        $mock = $this->getMockForTrait(AccountsTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'accounts',
                [
                    'json' => [
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f',
                        'jsonrpc' => '2.0',
                        'method' => 'getAccountsList',
                        'params' => [
                            'perPage' => 20,
                            'page' => 1
                        ]
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getAccountsList-success.json')
                )
            ));
        $actual = $mock->getAccountsList(1, 20);
    }
}