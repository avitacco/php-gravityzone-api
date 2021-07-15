<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\SandboxTrait;
use PHPUnit\Framework\TestCase;

class SandboxTraitTest extends TestCase
{

    public function testGetImagesList()
    {
        $mock = $this->getMockForTrait(SandboxTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('91d6430d-bfd4-494f-8d4d-4947406d21a7'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'sandbox',
                [
                    'json' => [
                        'params' => [
                            'sandboxId' => '5c419e6e26df3d367c49de18',
                            'page' => 1,
                            'perPage' => 20
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getImagesList',
                        'id' => '91d6430d-bfd4-494f-8d4d-4947406d21a7'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getImagesList-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getImagesList(
                '5c419e6e26df3d367c49de18',
                1,
                20
            )
        );
    }

    public function testGetSandboxAnalyzerInstancesList()
    {
        $mock = $this->getMockForTrait(SandboxTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('91d6430d-bfd4-494f-8d4d-4947406d21a7'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'sandbox',
                [
                    'json' => [
                        'params' => [
                            'page' => 1,
                            'perPage' => 20
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getSandboxAnalyzerInstancesList',
                        'id' => '91d6430d-bfd4-494f-8d4d-4947406d21a7'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getSandboxAnalyzerInstancesList-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getSandboxAnalyzerInstancesList(
                1,
                20
            )
        );
    }

    public function testGetSubmissionStatus()
    {
        $mock = $this->getMockForTrait(SandboxTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'sandbox',
                [
                    'json' => [
                        'params' => [
                            'submissionId' => 'sp02_1547807011_936_e5'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getSubmissionStatus',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getSubmissionStatus-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getSubmissionStatus('sp02_1547807011_936_e5')
        );
    }

    public function testGetDetonationDetails()
    {
        $mock = $this->getMockForTrait(SandboxTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'sandbox',
                [
                    'json' => [
                        'params' => [
                            'submissionId' => 'sp02_1547807011_936_e5'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getDetonationDetails',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getDetonationDetails-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getDetonationDetails('sp02_1547807011_936_e5')
        );
    }
}
