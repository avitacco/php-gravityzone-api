<?php

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\PackagesTrait;
use PHPUnit\Framework\TestCase;

class PackagesTraitTest extends TestCase
{

    public function testGetPackageDetails()
    {
        $mock = $this->getMockForTrait(PackagesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'packages',
                [
                    'json' => [
                        'params' => [
                            'packageId' => '5a37b660b1a43d99117b23c6'
                        ],
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f',
                        'jsonrpc' => '2.0',
                        'method' => 'getPackageDetails'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getPackageDetails-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getPackageDetails('5a37b660b1a43d99117b23c6')
        );
    }

    public function testGetPackagesList()
    {
        $mock = $this->getMockForTrait(PackagesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('103d7b05-ec02-481b-9ed6-c07b97de2b7a'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'packages',
                [
                    'json' => [
                        'params' => [
                            'page' => 1,
                            'perPage' => 5
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getPackagesList',
                        'id' => '103d7b05-ec02-481b-9ed6-c07b97de2b7a'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getPackagesList-success.json')
                )
            ));
        $this->assertIsArray(
            $mock->getPackagesList(
                1,
                5
            )
        );
    }

    public function testCreatePackage()
    {
        $mock = $this->getMockForTrait(PackagesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('426db9bb-e92a-4824-a21b-bba6b62d0a18'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'packages',
                [
                    'json' => [
                        'params' => [
                            'packageName' => 'a unique name',
                            'description' => 'package description',
                            'language' => 'en_EN',
                            'modules' => [
                                'advancedThreatControl' => 1,
                                'firewall' => 0,
                                'contentControl' => 1,
                                'deviceControl' => 0,
                                'powerUser' => 0,
                                'applicationControl' => 0,
                                'advancedAntiExploit' => 0,
                                'encryption' => 0,
                                'patchManagement' => 0,
                                'networkAttackDefense' => 0
                            ],
                            'scanMode' => [
                                'type' => 2,
                                'computers' => [
                                    'main' => 1,
                                    'fallback' => 2
                                ],
                                'vms' => [
                                    'main' => 2
                                ]
                            ],
                            'settings' => [
                                'uninstallPassword' => 'mys3cr3tP@assword',
                                'scanBeforeInstall' => 0,
                                'removeCompetitors' => 1,
                                'customInstallationPath' => 'c:\\mypath\\bitdefender',
                                'customGroupId' => '5a4dff50b1a43ded0a7b23c8',
                                'vmsCustomGroupId' => '5a4dff50b1a43ded0a7b23c7'
                            ],
                            'roles' => [
                                'relay' => 0,
                                'exchange' => 1
                            ],
                            'deploymentOptions' => [
                                'type' => 2,
                                'relayId' => '54a1a1s3b1a43e2b347s23c1',
                                'useCommunicationProxy' => true,
                                'proxyServer' => '10.12.13.14',
                                'proxyPort' => 123
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'createPackage',
                        'id' => '426db9bb-e92a-4824-a21b-bba6b62d0a18'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createPackage-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->createPackage(
                'a unique name',
                'package description',
                'en_EN',
                [
                    'advancedThreatControl' => 1,
                    'firewall' => 0,
                    'contentControl' => 1,
                    'deviceControl' => 0,
                    'powerUser' => 0,
                    'applicationControl' => 0,
                    'advancedAntiExploit' => 0,
                    'encryption' => 0,
                    'patchManagement' => 0,
                    'networkAttackDefense' => 0
                ],
                [
                    'type' => 2,
                    'computers' => [
                        'main' => 1,
                        'fallback' => 2
                    ],
                    'vms' => [
                        'main' => 2
                    ]
                ],
                [
                    'uninstallPassword' => 'mys3cr3tP@assword',
                    'scanBeforeInstall' => 0,
                    'removeCompetitors' => 1,
                    'customInstallationPath' => 'c:\\mypath\\bitdefender',
                    'customGroupId' => '5a4dff50b1a43ded0a7b23c8',
                    'vmsCustomGroupId' => '5a4dff50b1a43ded0a7b23c7'
                ],
                [
                    'relay' => 0,
                    'exchange' => 1
                ],
                [
                    'type' => 2,
                    'relayId' => '54a1a1s3b1a43e2b347s23c1',
                    'useCommunicationProxy' => true,
                    'proxyServer' => '10.12.13.14',
                    'proxyPort' => 123
                ]
            )
        );
    }

    public function testGetInstallationLinks()
    {
        $mock = $this->getMockForTrait(PackagesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('426db9bb-e92a-4824-a21b-bba6b62d0a18'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'packages',
                [
                    'json' => [
                        'params' => [
                            'packageName' => 'my package'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getInstallationLinks',
                        'id' => '426db9bb-e92a-4824-a21b-bba6b62d0a18'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getInstallationLinks-success.json')
                )
            ));
        $this->assertIsArray(
            $mock->getInstallationLinks('my package')
        );
    }

    public function testDeletePackage()
    {
        $mock = $this->getMockForTrait(PackagesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'packages',
                [
                    'json' => [
                        'params' => [
                            'packageId' => '5a37b660b1a43d99117b23c6'
                        ],
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f',
                        'jsonrpc' => '2.0',
                        'method' => 'deletePackage'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/deletePackage-success.json')
                )
            ));
        $this->assertNull(
            $mock->deletePackage('5a37b660b1a43d99117b23c6')
        );
    }
}
