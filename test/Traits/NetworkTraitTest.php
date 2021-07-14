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
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('301f7b05-ec02-481b-9ed6-c07b97de2b7b'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'endpointId' => '54a28b41b1a43d89367b23fd'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getManagedEndpointDetails',
                        'id' => '301f7b05-ec02-481b-9ed6-c07b97de2b7b'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getManagedEndpointDetails-success.json')
                )
            ));
        $this->assertIsArray(
            $mock->getManagedEndpointDetails(
                'virtualmachines',
                '54a28b41b1a43d89367b23fd'
            )
        );
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
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'targetIds' => [
                                '56728d66b1a43de92c712346',
                                '69738d66b1a43de92c712346'
                            ],
                            'inheritFromAbove' => false,
                            'policyId' => '55828d66b1a43de92c712345',
                            'forcePolicyInheritance' => true
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'assignPolicy',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/assignPolicy-success.json')
                )
            ));
        $this->assertTrue(
            $mock->assignPolicy(
                'virtualmachines',
                [
                    '56728d66b1a43de92c712346',
                    '69738d66b1a43de92c712346'
                ],
                false,
                '55828d66b1a43de92c712345',
                true
            )
        );
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
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'groupId' => '559bd17ab1a43d241b7b23c6',
                            'force' => true
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'deleteCustomGroup',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/deleteCustomGroup-success.json')
                )
            ));

        $this->assertNull(
            $mock->deleteCustomGroup(
                'virtualmachines',
                '559bd17ab1a43d241b7b23c6',
                true
            )
        );
    }

    public function testCreateCustomGroup()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('9600512e-4e89-438a-915d-1340c654ae34'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'groupName' => 'myGroup',
                            'parentId' => '5582c0acb1a43d9f7f7b23c6'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'createCustomGroup',
                        'id' => '9600512e-4e89-438a-915d-1340c654ae34'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createCustomGroup-success.json')
                )
            ));

        $this->assertEquals(
            '5582c210b1a43d967f7b23c6',
            $mock->createCustomGroup(
                'virtualmachines',
                'myGroup',
                '5582c0acb1a43d9f7f7b23c6'
            )
        );
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
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'groupId' => '559bd17ab1a43d241b7b23c6',
                            'parentId' => '559bd17ab1a85d241b7b23c6'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'moveCustomGroup',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/moveCustomGroup-success.json')
                )
            ));
        $this->assertNull(
            $mock->moveCustomGroup(
                'virtualmachines',
                '559bd17ab1a43d241b7b23c6',
                '559bd17ab1a85d241b7b23c6'
            )
        );
    }

    public function testSetEndpointLabel()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network',
                [
                    'json' => [
                        'params' => [
                            'endpointId' => '5a30e7730041d70cc09f244b',
                            'label' => 'label with url http://test.com?a=12&b=wow'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'setEndpointLabel',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/setEndpointLabel-success.json')
                )
            ));

        $this->assertTrue(
            $mock->setEndpointLabel(
                '5a30e7730041d70cc09f244b',
                'label with url http://test.com?a=12&b=wow'
            )
        );
    }

    public function testCreateScanTaskByMac()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network',
                [
                    'json' => [
                        'params' => [
                            'macAddresses' => [
                                '1c67da49e1a1',
                                '8c67f849e1a8'
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
                        'method' => 'createScanTaskByMac',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createScanTaskByMac-success.json')
                )
            ));

        $this->assertTrue(
            $mock->createScanTaskByMac(
                [
                    '1c67da49e1a1',
                    '8c67f849e1a8'
                ],
                4,
                'my scan',
                [
                    'scanDepth' => 1,
                    'scanPath' => [
                        'LocalDrives'
                    ]
                ]
            )
        );
    }

    public function testDeleteEndpoint()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'endpointId' => '559bd152b1a43d291b7b23d8'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'deleteEndpoint',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/deleteEndpoint-success.json')
                )
            ));

        $this->assertNull(
            $mock->deleteEndpoint(
                'virtualmachines',
                '559bd152b1a43d291b7b23d8'
            )
        );
    }

    public function testGetEndpointsList()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('103d7b05-ec02-481b-9ed6-c07b97de2b7a'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'parentId' => '23b19c39b1a43d89367b32ce',
                            'page' => 2,
                            'perPage' => 5,
                            'filters' => [
                                'security' => [
                                    'management' => [
                                        'managedWithBest' => true,
                                        'managedRelays' => true,
                                    ]
                                ]
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getEndpointsList',
                        'id' => '103d7b05-ec02-481b-9ed6-c07b97de2b7a'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getEndpointsList-success.json')
                )
            ));
        $this->assertIsArray(
            $mock->getEndpointsList(
                'virtualmachines',
                '23b19c39b1a43d89367b32ce',
                null,
                null,
                2,
                5,
                [
                    'security' => [
                        'management' => [
                            'managedWithBest' => true,
                            'managedRelays' => true,
                        ]
                    ]
                ]
            )
        );
    }

    public function testMoveEndpoints()
    {
        $mock = $this->getMockForTrait(NetworkTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'network/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'endpointIds' => [
                                '559bd152b1a43d291b7b23d8',
                                '559bd152b1a43d291b7b2430'
                            ],
                            'groupId' => '559bd17ab1a43d241b7b23c6'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'moveEndpoints',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/moveEndpoints-success.json')
                )
            ));

        $this->assertNull(
            $mock->moveEndpoints(
                'virtualmachines',
                [
                    '559bd152b1a43d291b7b23d8',
                    '559bd152b1a43d291b7b2430'
                ],
                '559bd17ab1a43d241b7b23c6'
            )
        );
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
                            'status' => 1,
                            'page' => 2,
                            'perPage' => 5
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getScanTasksList',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getScanTasksList-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getScanTasksList(
                'computers',
                null,
                1,
                2,
                5
            )
        );
    }
}
