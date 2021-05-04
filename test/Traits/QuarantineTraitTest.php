<?php
declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\QuarantineTrait;
use PHPUnit\Framework\TestCase;

class QuarantineTraitTest extends TestCase
{
    public function testGetQuarantineItemsList()
    {
        $mock = $this->getMockForTrait(QuarantineTrait::class);
        $mock->expects($this->any())
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
            ['actionStatus' => 0],
            '1'
        );

        $this->assertInstanceOf(
            Response::class,
            $actual
        );
    }
}
