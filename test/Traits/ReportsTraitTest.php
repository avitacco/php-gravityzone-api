<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\ReportsTrait;
use PHPUnit\Framework\TestCase;

class ReportsTraitTest extends TestCase
{

    public function testCreateReport()
    {
        $mock = $this->getMockForTrait(ReportsTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'reports/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'name' => 'My Report hourly',
                            'type' => 1,
                            'targetIds' => [
                                '559bd17ab1a43d241b7b23c6',
                                '559bd17ab1a43d241b7b23c7'
                            ],
                            'scheduledInfo' => [
                                'occurrence' => 2,
                                'interval' => 4
                            ],
                            'emailsList' => [
                                'user@company.com',
                                'user2@company.com'
                            ]
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'createReport',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createReport-success.json')
                )
            ));

        $this->assertEquals(
            '563c78e2b1a43d4043d60413',
            $mock->createReport(
                'virtualmachines',
                'My Report hourly',
                1,
                [
                    '559bd17ab1a43d241b7b23c6',
                    '559bd17ab1a43d241b7b23c7'
                ],
                [
                    'occurrence' => 2,
                    'interval' => 4
                ],
                null,
                [
                    'user@company.com',
                    'user2@company.com'
                ]
            )
        );
    }

    public function testGetReportsList()
    {
        $mock = $this->getMockForTrait(ReportsTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'reports/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'type' => 2,
                            'page' => 2,
                            'perPage' => 4
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getReportsList',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getReportsList-success.json')
                )
            ));
        $this->assertIsArray(
            $mock->getReportsList(
                'virtualmachines',
                2,
                null,
                2,
                4
            )
        );
    }

    public function testGetDownloadLinks()
    {
        $mock = $this->getMockForTrait(ReportsTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87g'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'reports',
                [
                    'json' => [
                        'params' => [
                            'reportId' => '5638d7f8b1a43d49137b23c9'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getDownloadLinks',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87g'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getDownloadLinks-ready.json')
                )
            ));
        $this->assertIsArray(
            $mock->getDownloadLinks(
                '5638d7f8b1a43d49137b23c9'
            )
        );
    }

    public function testDeleteReport()
    {
        $mock = $this->getMockForTrait(ReportsTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87g'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'reports',
                [
                    'json' => [
                        'params' => [
                            'reportId' => '5638d7f8b1a43d49137b23c9'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'deleteReport',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87g'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/deleteReport-success.json')
                )
            ));
        $this->assertTrue(
            $mock->deleteReport(
                '5638d7f8b1a43d49137b23c9'
            )
        );
    }
}
