<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test\Traits;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AccountsTraitTest extends TestCase
{
    public function testCreateAccount()
    {
        $mock = $this->getMockBuilder(AccountsTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->willReturn('787b5e36-89a8-4353-88b9-6b7a32e9c87f');

        $mock->expects($this->once())
            ->method('request')
            ->with(
                'accounts',
                [
                    'json' => [
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f',
                        'jsonrpc' => '2.0',
                        'method' => 'createAccount',
                        'params' => [
                            'email' => 'client@bitdefender.com',
                            'userName' => 'Client',
                            'profile' => [
                                'fullName' => 'Bitdefender User',
                                'language' => 'en_US',
                                'timezone' => 'Europe/Bucharest'
                            ],
                            'password' => 'P@s4w0rd',
                            'role' => 5,
                            'rights' => [
                                'manageNetworks' => true,
                                'manageReports' => true,
                                'manageUsers' => false
                            ],
                            'targetIds' => [
                                '585d2dc9aaed70820e8b45b4',
                                '585d2dd5aaed70b8048b45ca'
                            ]
                        ]
                    ]
                ]
            )
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createAccount-success.json')
                )
            );

        $actual = $mock->createAccount(
            'client@bitdefender.com',
            'Client',
            [
                'fullName' => 'Bitdefender User',
                'language' => 'en_US',
                'timezone' => 'Europe/Bucharest'
            ],
            'P@s4w0rd',
            5,
            [
                'manageNetworks' => true,
                'manageReports' => true,
                'manageUsers' => false
            ],
            [
                '585d2dc9aaed70820e8b45b4',
                '585d2dd5aaed70b8048b45ca'
            ]
        );

        $this->assertEquals(
            '585d2dc9aaed70820abc45b4',
            $actual
        );
    }
}
