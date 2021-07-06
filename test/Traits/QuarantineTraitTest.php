<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use Datto\JsonRpc\Exceptions\ArgumentException;
use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\QuarantineTrait;
use PHPUnit\Framework\TestCase;

class QuarantineTraitTest extends TestCase
{
    public function testGetQuarantineItemsList()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('1'));
        $mock->expects($this->once())
            ->method('request')
            ->with('quarantine/computers', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'getQuarantineItemsList',
                    'id' => '1',
                    'params' => [
                        'endpointId' => 'endpointID',
                        'page' => 1,
                        'perPage' => 30,
                        'filters' => [
                            'actionStatus' => 0
                        ]
                    ]
                ],
            ])
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/quarantineItemsList.json')
                )
            ));

        $actual = $mock->getQuarantineItemsList(
            'computers',
            'endpointID',
            1,
            30,
            ['actionStatus' => 0]
        );

        $this->assertIsString(($actual));
    }

    public function testCreateRemoveQuarantineItemTask()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);

        $mock->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue('1'));
        $mock->expects($this->exactly(2))
            ->method('request')
            ->with('quarantine/computers', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'createRemoveQuarantineItemTask',
                    'id' => '1',
                    'params' => [
                        'quarantineItemsIds' => ['63896b87b7894d0f367b23c6']
                    ],
                ],
            ])
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createRemoveQuarantineItemTask-success.json')
                ),
                new Response(
                    500,
                    [],
                    file_get_contents(__dir__ . '/data/createRemoveQuarantineItemTask-failure.json')
                )
            );

        // First time, removal works
        $actual = $mock->createRemoveQuarantineItemTask(
            'computers',
            ['63896b87b7894d0f367b23c6']
        );
        $this->assertTrue($actual);

        // Second time, it fails
        $this->expectException(ArgumentException::class);
        $mock->createRemoveQuarantineItemTask(
            'computers',
            ['63896b87b7894d0f367b23c6']
        );
    }

    public function testCreateEmptyQuarantineTask()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);

        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('5399c9b5-0b46-45e4-81aa-889952433d86'));
        $mock->expects($this->once())
            ->method('request')
            ->with('quarantine/computers', [
                'json' => [
                    'params' => [],
                    'jsonrpc' => '2.0',
                    'method' => 'createEmptyQuarantineTask',
                    'id' => '5399c9b5-0b46-45e4-81aa-889952433d86',
                ]
            ])
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createEmptyQuarantineTask-success.json')
                )
            ));

        $actual = $mock->createEmptyQuarantineTask('computers');
        $this->assertTrue($actual);
    }

    public function testCreateRestoreQuarantineItemTask()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);

        $mock->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue('1'));
        $mock->expects($this->exactly(2))
            ->method('request')
            ->with('quarantine/computers', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'createRestoreQuarantineItemTask',
                    'id' => '1',
                    'params' => [
                        'quarantineItemsIds' => ['63896b87b7894d0f367b23c6'],
                        'locationToRestore' => '/path/test',
                        'addExclusionInPolicy' => true
                    ],
                ],
            ])
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createRestoreQuarantineItemTask-success.json')
                ),
                new Response(
                    500,
                    [],
                    file_get_contents(__dir__ . '/data/createRestoreQuarantineItemTask-failure.json')
                )
            );

        // First time, removal works
        $actual = $mock->createRestoreQuarantineItemTask(
            ['63896b87b7894d0f367b23c6'],
            '/path/test',
            true
        );
        $this->assertTrue($actual);

        // Second time, it fails
        $this->expectException(ArgumentException::class);
        $mock->createRestoreQuarantineItemTask(
            ['63896b87b7894d0f367b23c6'],
            '/path/test',
            true
        );
    }

    public function testCreateRestoreQuarantineExchangeItemTask()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);

        $mock->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue('1'));
        $mock->expects($this->exactly(2))
            ->method('request')
            ->with('quarantine/exchange', [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'createRestoreQuarantineExchangeItemTask',
                    'id' => '1',
                    'params' => [
                        'quarantineItemsIds' => ['63896b87b7894d0f367b23c6'],
                        'username' => 'user@domain',
                        'password' => 'userPassword',
                        'email' => 'user@domain.tld',
                        'ewsUrl' => 'https://valid.tld/ews'
                    ],
                ],
            ])
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createRestoreQuarantineExchangeItemTask-success.json')
                ),
                new Response(
                    500,
                    [],
                    file_get_contents(__dir__ . '/data/createRestoreQuarantineExchangeItemTask-failure.json')
                )
            );

        // First time, removal works
        $actual = $mock->createRestoreQuarantineExchangeItemTask(
            ['63896b87b7894d0f367b23c6'],
            'user@domain',
            'userPassword',
            'user@domain.tld',
            'https://valid.tld/ews'
        );
        $this->assertTrue($actual);

        // Second time, it fails
        $this->expectException(ArgumentException::class);
        $mock->createRestoreQuarantineExchangeItemTask(
            ['63896b87b7894d0f367b23c6'],
            'user@domain',
            'userPassword',
            'user@domain.tld',
            'https://valid.tld/ews'
        );
    }
}
