<?php

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Traits\PoliciesTrait;
use PHPUnit\Framework\TestCase;

class PoliciesTraitTest extends TestCase
{

    public function testGetPoliciesList()
    {
        $mock = $this->getMockForTrait(PoliciesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('5399c9b5-0b46-45e4-81aa-889952433d86'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'policies/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'page' => 1,
                            'perPage' => 2
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getPoliciesList',
                        'id' => '5399c9b5-0b46-45e4-81aa-889952433d86'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getPoliciesList-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getPoliciesList(
                'virtualmachines',
                1,
                2
            )
        );
    }

    public function testGetPolicyDetails()
    {
        $mock = $this->getMockForTrait(PoliciesTrait::class);
        $mock->expects($this->once())
            ->method('getId')
            ->will($this->returnValue('47519d2d-92e0-4a1f-b06d-aa458e80f610'));
        $mock->expects($this->once())
            ->method('request')
            ->with(
                'policies/virtualmachines',
                [
                    'json' => [
                        'params' => [
                            'policyId' => '55828d66b1a43de92c712345'
                        ],
                        'jsonrpc' => '2.0',
                        'method' => 'getPolicyDetails',
                        'id' => '47519d2d-92e0-4a1f-b06d-aa458e80f610'
                    ]
                ]
            )
            ->will($this->returnValue(
                new Response(
                    200,
                    [],
                    file_get_contents(__dir__ . '/data/getPolicyDetails-success.json')
                )
            ));

        $this->assertIsArray(
            $mock->getPolicyDetails(
                'virtualmachines',
                '55828d66b1a43de92c712345'
            )
        );
    }
}
