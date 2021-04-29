<?php
declare(strict_types=1);

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use IndianaUniversity\GravityZone\Provider\Web\Web;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
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

        $provider = new Web('gravityzone.example.net', 'example api key', $handlerStack);
        $provider->get('test');

        $this->assertCount(1, $container);

        $transaction = $container[0];
        $this->assertEquals(
            base64_encode('example api key:'),
            explode(' ', $transaction['request']->getHeaders()['Auth'][0])[1]
        );

        $this->assertTrue(true);
    }
}