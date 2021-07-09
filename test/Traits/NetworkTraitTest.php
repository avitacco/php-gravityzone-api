<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;


use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\NetworkTrait;
use PHPUnit\Framework\TestCase;

class NetworkTraitTest extends TestCase
{

    public function testGetManagedEndpointDetails()
    {

    }

    public function testGetContainers()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/computers',
                [
                    'json' => [
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f',
                        'jsonrpc' => '2.0',
                        'method' => 'getContainers',
                        'params' => [
                            'parentId' => '559bd17ab1a43d241b7b23c6',
                            'viewType' => 4
                        ]
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getContainers-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getContainers(
                'computers',
                '559bd17ab1a43d241b7b23c6',
                4
            )
        );
    }

    public function testAssignPolicy()
    {

    }

    public function testGetNetworkInventoryItems()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('301f7b05-ec02-481b-9ed6-c07b97de2b7b'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/computers',
                [
                    'json' => [
                        'params' => [
                            'parentId' => '23b19c39b1a43d89367b32ce',
                            'page' => 2,
                            'perPage' => 5,
                            'filters' => [
                                'type' => [
                                    'computers' => true
                                ],
                                'depth' => [
                                    'allItemsRecursively' => true
                                ]
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getNetworkInventoryItems',
                        'id' => '301f7b05-ec02-481b-9ed6-c07b97de2b7b'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getNetworkInventoryItems-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getNetworkInventoryItems(
                'computers',
                '23b19c39b1a43d89367b32ce',
                [
                    'type' => ['computers' => true],
                    'depth' => ['allItemsRecursively' => true]
                ],
                null,
                2,
                5
            )
        );
    }

    public function testDeleteCustomGroup()
    {

    }

    public function testCreateCustomGroup()
    {

    }

    public function testCreateReconfigureClientTask()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/computers',
                [
                    'json' => [
                        'params' => [
                            'targetIds' => [
                                '5d7244b10ea1de153817c072'
                            ],
                            'scheduler' => ['type' => 1],
                            'modules' => [
                                'advancedThreatControl' => 1,
                                'firewall' => 1,
                                'contentControl' => 1,
                                'deviceControl' => 1,
                                'powerUser' => 1,
                                'encryption' => 1,
                                'advancedAntiExploit' => 1,
                                'patchManagement' => 1,
                                'applicationControl' => 1,
                                'networkAttackDefense' => 1
                            ],
                            'scanMode' => ['type' => 1],
                            'roles' => [
                                'relay' => 0,
                                'exchange' => 0
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'createReconfigureClientTask',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createReconfigureClientTask-success.json')
                )
            ));

        $this->assertTrue(
            $mock->createReconfigureClientTask(
                'computers',
                ['5d7244b10ea1de153817c072'],
                ['type' => 1],
                [
                    'advancedThreatControl' => 1,
                    'firewall' => 1,
                    'contentControl' => 1,
                    'deviceControl' => 1,
                    'powerUser' => 1,
                    'encryption' => 1,
                    'advancedAntiExploit' => 1,
                    'patchManagement' => 1,
                    'applicationControl' => 1,
                    'networkAttackDefense' => 1
                ],
                ['type' => 1],
                [
                    'relay' => 0,
                    'exchange' => 0
                ]
            )
        );
    }

    public function testMoveCustomGroup()
    {

    }

    public function testSetEndpointLabel()
    {

    }

    public function testCreateScanTaskByMac()
    {

    }

    public function testDeleteEndpoint()
    {

    }

    public function testGetEndpointsList()
    {

    }

    public function testMoveEndpoints()
    {

    }

    public function testCreateScanTask()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/computers',
                [
                    'json' => [
                        'params' => [
                            'targetIds' => [
                                '559bd17ab1a43d241b7b23c6',
                                '559bd17ab1a43d241b7b23c7'
                            ],
                            'type' => 4,
                            'name' => 'my scan',
                            'customScanSettings' => [
                                'scanDepth' => 1,
                                'scanPath' => [
                                    'LocalDrives'
                                ]
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'createScanTask',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createScanTask-success.json')
                )
            ));

        $this->assertTrue(
            $mock->createScanTask(
                'computers',
                [
                    '559bd17ab1a43d241b7b23c6',
                    '559bd17ab1a43d241b7b23c7'
                ],
                4,
                [
                    'scanDepth' => 1,
                    'scanPath' => ['LocalDrives']
                ],
                'my scan'
            )
        );
    }

    public function testGetScanTasksList()
    {

    }
}
