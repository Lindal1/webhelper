<?php

use lindal\webhelper\errors\NotFoundException;
use lindal\webhelper\Request;
use lindal\webhelper\Response;
use lindal\webhelper\routing\Router;
use lindal\webhelper\routing\Rule;
use lindal\webhelper\test\TestController;

class RouterTest extends \PHPUnit\Framework\TestCase
{

    public $router;

    public function setUp()
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $request->method('getMethod')
            ->willReturn('GET');
        $request->method('getUri')
            ->willReturn('/user/45');
        $this->router = new Router($request, $response);
    }

    public function testAddRule()
    {
        $rule = $this->createMock(Rule::class);
        $this->assertInstanceOf(Router::class, $this->router->addRule($rule));
    }


    public function testExecute()
    {
        $rule = $this->createMock(Rule::class);
        $rule->method('getClass')
            ->willReturn(TestController::class);
        $rule->method('getHandler')
            ->willReturn('execute');
        $rule->method('match')
            ->willReturn(true);
        $rule->method('extractParams')
            ->willReturn(['id' => 3]);
        $rule->method('getMethod')
            ->willReturn('GET');
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $request->method('getMethod')
            ->willReturn('GET');
        $request->method('getUri')
            ->willReturn('/user/3');
        $router = new Router($request, $response);
        $router->addRule($rule);
        $router->execute();
    }

}