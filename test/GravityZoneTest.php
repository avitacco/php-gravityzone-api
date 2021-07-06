<?php

/**
 * @copyright 2021 The Trustees of Indiana University
 * @license BSD-3-Clause
 */

declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Test;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\GravityZone;
use PHPUnit\Framework\TestCase;

class GravityZoneTest extends TestCase
{
    public function testAuthentication()
    {
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], 'This is a mock response!')
        ]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $gz = new GravityZone(
            'gravityzone.example.net',
            'example api key',
            $handlerStack
        );
        $gz->request('test');

        $this->assertCount(1, $container);

        $transaction = $container[0];
        $this->assertEquals(
            base64_encode('example api key:'),
            explode(' ', $transaction['request']->getHeaders()['Authorization'][0])[1]
        );

        $this->assertTrue(true);
    }

    public function testGetId()
    {
        $gz = new GravityZone(
            'gravityzone.example.net',
            'example api key'
        );

        $this->assertIsString($gz->getId());
    }
}
