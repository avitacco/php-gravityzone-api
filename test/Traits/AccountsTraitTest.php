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

    public function testDeleteAccount()
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
                        'method' => 'deleteAccount',
                        'params' => [
                            'accountId' => '585d3810aaed70cc068b45f8'
                        ]
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/deleteAccount-success.json')
                )
            ));
        $this->assertNull(
            $mock->deleteAccount('585d3810aaed70cc068b45f8')
        );
    }

    public function testCreateAccount()
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
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createAccount-success.json')
                )
            ));

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

    public function testUpdateAccount()
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
                        'method' => 'updateAccount',
                        'params' => [
                            'accountId' => '585d3d3faaed70970e8b45ed',
                            'email' => 'client@bitdefender.com',
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
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/updateAccount-success.json')
                )
            ));

        $this->assertTrue(
            $mock->updateAccount(
                '585d3d3faaed70970e8b45ed',
                'client@bitdefender.com',
                null,
                'P@s4w0rd',
                [
                    'fullName' => 'Bitdefender User',
                    'language' => 'en_US',
                    'timezone' => 'Europe/Bucharest'
                ],
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
            )
        );
    }

    public function testUpdateNotificationsSettings()
    {
        $mock = $this->getMockForTrait(AccountsTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('5399c9b5-0b46-45e4-81aa-889952433d68'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'accounts',
                [
                    'json' => [
                        'params' => [
                            'accountId' => '55896b87b7894d0f367b23c8',
                            'deleteAfter' => 17,
                            'includeDeviceName' => true,
                            'includeDeviceFQDN' => true,
                            'emailAddresses' => ['example1@example.net'],
                            'notificationsSettings' => [
                                [
                                    'type' => 1,
                                    'enabled' => true,
                                    'visibilitySettings' => [
                                        'sendPerEmail' => true,
                                        'showInConsole' => true,
                                        'useCustomEmailDistribution' => false,
                                        'emails' => ['example2@example.com'],
                                        'logToServer' => true
                                    ],
                                    'configurationSettings' => [
                                        'threshold' => 15,
                                        'useThreshold' => true
                                    ]
                                ]
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'configureNotificationsSettings',
                        'id' => '5399c9b5-0b46-45e4-81aa-889952433d68'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/configureNotificationsSettings-success.json')
                )
            ));

        $this->assertTrue(
            $mock->configureNotificationsSettings(
                '55896b87b7894d0f367b23c8',
                17,
                ['example1@example.net'],
                true,
                true,
                [
                    [
                        'type' => 1,
                        'enabled' => true,
                        'visibilitySettings' => [
                            'sendPerEmail' => true,
                            'showInConsole' => true,
                            'useCustomEmailDistribution' => false,
                            'emails' => ['example2@example.com'],
                            'logToServer' => true
                        ],
                        'configurationSettings' => [
                            'threshold' => 15,
                            'useThreshold' => true
                        ]
                    ]
                ]
            )
        );
    }

    public function testGetNotificationsSettings()
    {
        $mock = $this->getMockForTrait(AccountsTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('5399c9b5-0b46-45e4-81aa-889952433d86'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'accounts',
                [
                    'json' => [
                        'params' => [
                            'accountId' => '55896b87b7894d0f367b23c8'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getNotificationsSettings',
                        'id' => '5399c9b5-0b46-45e4-81aa-889952433d86'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getNotificationsSettings.json')
                )
            ));

        $actual = $mock->getNotificationsSettings('55896b87b7894d0f367b23c8');
        $this->assertIsArray($actual);
        $this->assertArrayHasKey('deleteAfter', $actual);
    }
}
