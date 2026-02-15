<?php

namespace IndianaUniversity\GravityZone\Test\Traits;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\GeneralTrait;
use PHPUnit\Framework\TestCase;

class GeneralTraitTest extends TestCase
{
    public function testGetApiKeyDetails()
    {
        $mock = $this->getMockBuilder(GeneralTraitTestClassForMocking::class)
            ->onlyMethods(['getId', 'request'])
            ->getMock();

        $mock->expects($this->once())
            ->method('getId')
            ->willReturn('787b5e36-89a8-4353-88b9-6b7a32e9c87f');

        $mock->expects($this->once())
            ->method('request')
            ->with(
                'general',
                [
                    'json' => [
                        'params' => [],
                        'jsonrpc' => '2.0',
                        'method' => 'getApiKeyDetails',
                        'id' => '787b5e36-89a8-4353-88b9-6b7a32e9c87f'
                    ]
                ]
            )
            ->willReturn(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getApiKeyDetails-success.json')
                )
            );

        $this->assertIsArray(
            $mock->getApiKeyDetails()
        );
    }
}
