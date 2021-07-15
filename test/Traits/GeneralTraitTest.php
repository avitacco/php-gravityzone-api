<?php

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\GeneralTrait;
use PHPUnit\Framework\TestCase;

class GeneralTraitTest extends TestCase
{

    public function testGetApiKeyDetails()
    {
        $mock = $this->getMockForTrait(GeneralTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('787b5e36-89a8-4353-88b9-6b7a32e9c87f'));
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
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getApiKeyDetails-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getApiKeyDetails()
        );
    }
}
