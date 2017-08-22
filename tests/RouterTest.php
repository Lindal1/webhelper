<?php

use lindal\webhelper\Request;
use lindal\webhelper\routing\Router;
use lindal\webhelper\routing\Rule;
use lindal\webhelper\test\TestController;

class RouterTest extends \PHPUnit\Framework\TestCase
{

    public $router;

    public function setUp()
    {
        $request = $this->createMock(Request::class);
        $request->method('getMethod')
            ->willReturn('GET');
        $request->method('getUri')
            ->willReturn('/user/45');
        $this->router = new Router([], $request);
    }

    public function testAddRule()
    {
        $rule = $this->createMock(Rule::class);
        $this->assertInstanceOf(Router::class, $this->router->addRule($rule));
    }

    /**
     * @param $uri
     * @param $method
     * @param $expected
     */
    public function testExecute($uri, $method, $expected)
    {
        $controller = $this->createMock(TestController::class);
        $controller->method('handler1')
            ->willReturn('result1');
        $rules = [
            new Rule('TestController', 'handler1', '/users'),
            new Rule('TestController', 'handler2', '/users/{id}'),
            new Rule('TestController', 'handler3', '/users/{id}', 'POST'),
            new Rule('TestController', 'handler4', '/users/{id}/books'),
        ];
        $request = $this->createMock(Request::class);
        $request->method('getMethod')
            ->willReturn($method);
        $request->method('getUri')
            ->willReturn($uri);
        $router = new Router([], $request);
    }

}