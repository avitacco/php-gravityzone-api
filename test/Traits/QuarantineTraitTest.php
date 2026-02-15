<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test\Traits;

use Datto\JsonRpc\Exceptions\ArgumentException;
use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\QuarantineTrait;
use PHPUnit\Framework\TestCase;

class QuarantineTraitTest extends TestCase
{
    public function testCreateEmptyQuarantineTask()
    {
        $mock = $this->getMockBuilder(QuarantineTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->willReturn('5399c9b5-0b46-45e4-81aa-889952433d86');

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
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/createEmptyQuarantineTask-success.json')
                )
            );

        $actual = $mock->createEmptyQuarantineTask('computers');
        $this->assertTrue($actual);
    }

    public function testCreateRestoreQuarantineExchangeItemTask()
    {
        $mock = $this->getMockBuilder(QuarantineTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('getId')
            ->willReturn('1');

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
