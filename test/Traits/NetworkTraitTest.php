<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test\Traits;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class NetworkTraitTest extends TestCase
{
    public function testCreateScanTask()
    {
        $mock = $this->getMockBuilder(NetworkTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->willReturn('787b5e36-89a8-4353-88b9-6b7a32e9c87f');

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
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createScanTask-success.json')
                )
            );

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

    public function testCreateScanTaskByMac()
    {
        $mock = $this->getMockBuilder(NetworkTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->willReturn('787b5e36-89a8-4353-88b9-6b7a32e9c87f');

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
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createScanTaskByMac-success.json')
                )
            );

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
}
